<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OverworkController;
use App\Http\Controllers\RequestController;

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

Route::middleware('auth')->group(function () {
    //! overwork
    Route::prefix('overwork')->name('overwork.')->group(function () {
        Route::get('/form', [OverworkController::class, 'create'])->name('form-view');
        Route::post('/proccess', [OverworkController::class, 'store'])->name('insert');
    });

    //! leave
    Route::prefix('leave')->name('leave.')->group(function () {
        Route::get('/form', [LeaveController::class, 'create'])->name('form-view');
        Route::post('/proccess', [LeaveController::class, 'store'])->name('insert');
    });

    //! draft
    Route::get('/draft', [RequestController::class, 'showDraft'])->name('draft');

    //! recent 
    Route::get('/recent-request', [RequestController::class, 'showRecent'])->name('recent');
});

require __DIR__ . '/auth.php';
