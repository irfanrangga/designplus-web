<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Wishlist;

class ProfileController extends Controller
{  
    public function index()
{
    // ambil data wishlist milik user yang sedang login beserta data produknya
    $wishlists = Wishlist::with('product')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();

    return view('profile', compact('wishlists')); // kirim variabel $wishlists ke view
}

    /**
     * Menyimpan pembaruan data User Info (Informasi Pribadi).
     */
    public function updateUserInfo(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'full_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
        ]);

        // 2. Ambil User yang sedang login
        $user = Auth::user();

        // 3. Update data user
        $user->name = $request->name;
        $user->full_name = $request->full_name;
        $user->phone = $request->phone;
        $user->location = $request->location;
        $user->postal_code = $request->postal_code;
        $user->save();

        // 4. Redirect kembali ke sub-halaman user-info dengan pesan sukses
        return redirect()->route('profile', ['page' => 'user-info'])->with('success', 'Informasi profil berhasil diperbarui!');
    }

    /**
     * Menyimpan pembaruan Kata Sandi (Password).
     */
    public function updatePassword(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
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
        $user = Auth::user();

        // 3. Hash dan simpan password baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        // 4. Redirect kembali ke sub-halaman pengaturan dengan pesan sukses
        return redirect()->route('profile', ['page' => 'pengaturan'])->with('success', 'Kata sandi berhasil diperbarui!');
    }
}
