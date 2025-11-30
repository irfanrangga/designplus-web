<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// 1. Rute Beranda (Root URL) -> Arahkan ke view homepage
Route::get('/', function () {
    return view('homepage'); // Pastikan file resources/views/homepage.blade.php ada
})->name('home');

// 2. Rute Layanan -> Arahkan ke view layanan
Route::get('/layanan', function () {
    return view('layanan'); // Pastikan file resources/views/layanan.blade.php ada
})->name('layanan');

// 3. Rute Produk (Menggunakan Controller yang sudah kita buat)
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');