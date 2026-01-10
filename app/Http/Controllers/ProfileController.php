<?php

namespace App\Http\Controllers;

use App\Helpers\ApiClient;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        // ambil data wishlist milik user yang sedang login beserta data produknya
        $wishlists = Wishlist::with('product')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $orders = Order::with('items.product')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('profile', compact('wishlists', 'orders'));
    }

    /**
     * Menyimpan pembaruan data User Info (Informasi Pribadi).
     */
    public function updateUserInfo(Request $request)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'full_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
        ]);

        // 2. Pastikan user login (session)
        if (!session()->has('jwt_token')) {
            return redirect()->route('login');
        }
        $userId = session('user_id');
        // 3. Kirim ke API
        $response = ApiClient::put('/users/' . $userId, $validated);

        if ($response->failed()) {
            return back()->withErrors([
                'error' => 'Gagal memperbarui profil'
            ]);
        }

        // 4. Update session (sinkron)
        $user = $response->json('data');

        // Simpan perubahan biar bisa dipanggil di view
        Session::put('user_name', $user['name']);
        Session::put('user_email', $user['email'] ?? session('user_email'));
        Session::put('user_full_name', $user['full_name'] ?? null);
        Session::put('user_phone', $user['phone'] ?? null);
        Session::put('user_location', $user['location'] ?? null);
        Session::put('user_postal_code', $user['postal_code'] ?? null);

        // 5. Redirect kembali ke sub-halaman user-info dengan pesan sukses
        return redirect()->route('profile', ['page' => 'user-info'])->with('success', 'Informasi profil berhasil diperbarui!');
    }

    /**
     * Menyimpan pembaruan Kata Sandi (Password).
     */
    public function updatePassword(Request $request)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            // current_password harus diverifikasi terhadap password di database
            'current_password' => ['required', 'current_password'],
            // Password baru minimal 8 karakter dan harus dikonfirmasi
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'new_password.min' => 'Kata sandi baru minimal harus 8 karakter.',
        ]);

        // 2. Ambil User yang sedang login
        $token = session('jwt_token');
        if (!$token) {
        return redirect()->route('login')
            ->withErrors(['auth' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
        }

        $response = ApiClient::put('/users/password/me', $validated);

        // 3. Hash dan simpan password baru
        if ($response->failed()) {
            return back()->withErrors([
                'current_password' =>
                    $response->json('message') ?? 'Gagal memperbarui kata sandi.'
            ]);
        }

        // 4. Redirect kembali ke sub-halaman pengaturan dengan pesan sukses
        return redirect()->route('profile', ['page' => 'pengaturan'])->with('success', 'Kata sandi berhasil diperbarui!');
    }
}
