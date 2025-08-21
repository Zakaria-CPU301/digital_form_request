<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/pages/dashboard');
})->name('home');

Route::get('/add-user', function () {
    return view('/pages/addUser');
})->name('page-addUser');

Route::post('/insert', [AccountController::class, 'store'])->name('insert');

Route::get('/login', function () {
    return view('pages.login');
})->name('page-login');