<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\Session; 
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Helpers\ApiClient;

class GoogleController extends Controller
{


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $response = ApiClient::post('/auth/google', [
                'email'     => $googleUser->getEmail(),
                'name'      => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);

            if ($response->failed()) {
                return redirect()->route('login')->withErrors(['email' => 'Gagal login via Google ke server API.']);
            }

            $token = $response->json('token') ?? $response->json('data.token');

            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            $user = new User([
                'id'    => $decoded->id,
                'name'  => $decoded->name,
                'email' => $decoded->email,
                'role'  => $decoded->role
            ]);

            Auth::login($user);

            Session::put('jwt_token', $token);
            Session::put('user_role', $decoded->role);
            Session::put('user_id', $decoded->id);
            Session::put('user_name', $decoded->name);
            Session::put('user_email', $decoded->email);

            return redirect()->route('home');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }   
}
