<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OverworkController;

Route::get('/', function () {
    return view('/pages/dashboard');
})->name('home');

// user account
Route::get('/add-user', function () {
    return view('/pages/addUser');
})->name('page-addUser');

Route::post('/insert', [AccountController::class, 'store'])->name('insert');

Route::get('/login', function () {
    return view('pages.login');
})->name('page-login');

// overwork
Route::prefix('overwork')->name('overwork.')->group(function () {
    Route::get('/form', function() {
        return view('pages.overwork_request');
    })->name('form-view');
    Route::post('/proccess', [OverworkController::class, 'store'])->name('insert');
});
