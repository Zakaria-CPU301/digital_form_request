<?php

use App\Models\Leave;
use App\Models\Account;
use App\Models\Overwork;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OverworkController;

Route::get('/', function () {
    return view('/pages/dashboard');
})->name('home');

// user account
Route::get('/add-user', function () {
    return view('view.admin.add_user');
})->name('page-addUser');

Route::prefix('account')->group(function () {
    Route::post('/insert', [AccountController::class, 'store'])->name('insert');
    
    Route::get('/login', function () {
        return view('pages.login');
    })->name('page-login');
});

// overwork
Route::prefix('overwork')->name('overwork.')->group(function () {
    Route::get('/form', function() {
        return view('pages.overwork_request', Account::first());
    })->name('form-view');
    Route::post('/proccess', [OverworkController::class, 'store'])->name('insert');
});

Route::prefix('leave')->name('leave.')->group(function() {
    Route::get('/form', function() {
        return view('pages.leave_request', ['account' => Account::first()]);
    })->name('form-view');
    Route::post('/proccess', [LeaveController::class, 'store'])->name('insert');
});

Route::get('/draft', function() {
    $overworks = [Overwork::all(), 'overwork'];
    $leaves = [Leave::all(), 'leave'];
    return view('view.users.draft', compact('overworks', 'leaves'));
})->name('draft');