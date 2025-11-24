<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/test', function () {
//     return 'This is a test route.';
// });

Route::get('/product', function () {
    return view('product-page');
});
