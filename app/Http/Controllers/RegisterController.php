<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth; // Tidak dipakai karena kita redirect ke login

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        // 1. VALIDASI DATA
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        // 2. ENKRIPSI PASSWORD
        $validatedData['password'] = Hash::make($validatedData['password']);

        // 3. BUAT PENGGUNA BARU
        User::create($validatedData);

        // 4. REDIRECT KE LOGIN DENGAN PESAN SUKSES
        return redirect()
               ->route('login')
               ->with('success', 'Akun berhasil dibuat! Silakan login untuk melanjutkan.');
    }
}
