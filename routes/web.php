<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return 'This is a test route.';
});