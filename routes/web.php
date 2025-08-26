<?php

use App\Models\Leave;
use App\Models\Account;
use App\Models\Overwork;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OverworkController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('account')->name('account.')->group(function () {
    Route::get('/add', [AccountController::class, 'create'])->name('page-addUser');
    Route::post('/insert', [AccountController::class, 'store'])->name('insert');
});

Route::middleware('auth')->group(function () {
    // overwork
    Route::prefix('overwork')->name('overwork.')->group(function () {
        Route::get('/form', [OverworkController::class, 'create'])->name('form-view');
        Route::post('/proccess', [OverworkController::class, 'store'])->name('insert');
    });

    Route::prefix('leave')->name('leave.')->group(function () {
        Route::get('/form', [LeaveController::class, 'create'])->name('form-view');
        Route::post('/proccess', [LeaveController::class, 'store'])->name('insert');
    });

    Route::get('/draft', function () {
        $overworks = [Overwork::all(), 'overwork'];
        $leaves = [Leave::all(), 'leave'];
        return view('view.users.draft', compact('overworks', 'leaves'));
    })->name('draft');
});

require __DIR__ . '/auth.php';
