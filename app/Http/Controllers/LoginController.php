<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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
        $response = Http::post(
            env('API_BASE_URL') . '/login',
            $request->only('email', 'password')
        );

        if ($response->failed()) {
            return back()
            ->withInput()
            ->withErrors([
                'email' => $response->json('message') ?? 'Email atau password salah'
            ]);
        }

        $token = $response->json('token')
                ?? $response->json('data.token');

        if(!$token) {
            return back()
                ->withInput()
                ->withErrors([
                'email' => 'Token tidak diterima dari API'
                ]);
        }

        // Decode JWT untuk ambil role
        $decoded = JWT::decode(
            $token, 
            new Key(env('JWT_SECRET'), 'HS256')
        );

        // Simpan ke session
        Session::put('jwt_token', $token);
        Session::put('user_role', $decoded->role);
        Session::put('jwt_token', $token);
        Session::put('user_id', $decoded->id);
        Session::put('user_role', $decoded->role);
        Session::put('user_name', $decoded->name ?? $decoded->email);
        Session::put('user_email', $decoded->email);

        return redirect()->route('home');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->session()->forget([
            'jwt_token',
            'user_role',
            'user_name',
            'user_email',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil keluar.');
    }
}
