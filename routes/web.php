<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('homepage'); 
})->name('home');

Route::get('/layanan', function () {
    return view('layanan'); 
})->name('layanan');

Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/payment', [PaymentController::class, 'index']);