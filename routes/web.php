<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\OverworkController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Symfony\Component\Routing\RequestContext;

Route::get('/', function () {
    $view = Auth::id() === null ? route('login') : route('dashboard');
    return redirect($view);
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    //! dashboard
    Route::match(['get', 'post'], '/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    //! overwork
    Route::prefix('overwork')->name('overwork.')->group(function () {
        Route::get('/form', [OverworkController::class, 'create'])->name('form-view');
        Route::post('/proccess', [OverworkController::class, 'store'])->name('insert');
        Route::get('/{overwork}/edit', [OverworkController::class, 'edit'])->name('edit');
        Route::put('/{overwork}', [OverworkController::class, 'update'])->name('update');
    });

    //! leave
    Route::prefix('leave')->name('leave.')->group(function () {
        Route::get('/form', [LeaveController::class, 'create'])->name('form-view');
        Route::post('/proccess', [LeaveController::class, 'store'])->name('insert');
        Route::get('/{leave}/edit', [LeaveController::class, 'edit'])->name('edit');
        Route::put('/{leave}', [LeaveController::class, 'update'])->name('update');
    });

    //! draft
    Route::get('/draft', [RequestController::class, 'showDraft'])->name('draft');

    //! recent 
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/recent', [RequestController::class, 'showRecent'])->name('recent');
    });
});

require __DIR__ . '/auth.php';
