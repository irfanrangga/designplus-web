<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController; // Tambahkan ini
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WebhookController;

/*
|--------------------------------------------------------------------------
| PUBLIC & GUEST ROUTES (Dapat Diakses Semua Orang)
|--------------------------------------------------------------------------
*/

// HOME
Route::get('/', function () {
    return view('homepage');
})->name('home');

// LAYANAN
Route::get('/layanan', function () {
    return view('layanan');
})->name('layanan');

Route::get('/product-detail', function () {
    return view('product-detail');
})->name('product-detail');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Dashboard route: redirect to Filament admin panel path
Route::get('/dashboard', function () {
    return redirect(config('filament.path', 'admin'));
})->name('dashboard');

// PRODUCT (Etalase & Detail)
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION (Login & Register)
|--------------------------------------------------------------------------
*/

// Register
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Login
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.process');
});


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Hanya bisa diakses setelah login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // LOGOUT
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // DASHBOARD/PENGATURAN AKUN (Profile)
    // Menggunakan query parameter (?page=...) untuk switch case
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Rute untuk pembaruan data
    // PERBAIKAN: updateInfo() diubah menjadi updateUserInfo()
    Route::put('/profile/update-info', [ProfileController::class, 'updateUserInfo'])->name('profile.update-info');

    // Rute ini sudah benar
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/payment/{id}', [CheckoutController::class, 'show'])->name('payment.show');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

Route::post('/webhook/xendit', [WebhookController::class, 'handle'])->name('webhook.xendit');
