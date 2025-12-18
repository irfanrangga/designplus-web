<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // TAMPILKAN FORM LOGIN
    public function index()
    {
        return view('login');
    }

    // PROSES LOGIN
    public function authenticate(Request $request)
    {
        // 1. VALIDASI INPUT
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. COBA AUTENTIKASI
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect ke intended URL atau default '/'
            return redirect()->intended('/')->with('success', 'Selamat datang kembali!');
        }

        // 3. JIKA GAGAL
        // Menggunakan 'loginError' dan withInput untuk mempertahankan email
        return back()
               ->withInput()
               ->with('loginError', 'Kombinasi Email dan Password tidak ditemukan.');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil keluar.');
    }
}
