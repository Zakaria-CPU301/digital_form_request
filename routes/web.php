<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/pages/dashboard');
})->name('home');

Route::get('/pages/login', function () {
    return view('/pages/login');
})->name('login-page');

Route::post('/login', [AccountController::class, 'store'])->name('login');