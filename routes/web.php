<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('homepage'); 
})->name('home');

Route::get('/layanan', function () {
    return view('layanan'); 
})->name('layanan');

Route::get('/product-detail', function () {
    return view('product-detail'); 
})->name('product-detail');

Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
