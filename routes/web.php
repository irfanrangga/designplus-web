<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product-detail', function() {
    return view('product-detail');
});

Route::get('/product', function () {
    return view('product-page');
});

Route::get('/test', function () {
    return view('test-page');
});