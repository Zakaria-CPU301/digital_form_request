<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\OverworkController;
use App\Http\Controllers\DashboardController;
use Symfony\Component\Routing\RequestContext;
use App\Http\Controllers\ManageDataController;
use App\Http\Controllers\ManageAccountController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;



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
    
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::prefix('request')->name('request.')->group(function () {
            Route::get('/data', [ManageDataController::class, 'show'])->name('show');
            Route::get('edit/{id}', [ManageDataController::class, 'edit'])->name('edit');
        });
        Route::prefix('account')->name('account.')->group(function () {
            Route::get('/', [ManageAccountController::class, 'show'])->name('show');
            Route::get('edit/{id}', [ManageAccountController::class, 'edit'])->name('edit');
            Route::get('delete/{id}', [ManageAccountController::class, 'destroy'])->name('delete');
        });
    });
    
    Route::middleware(['auth', 'role:user'])->group(function () {
    //! overwork
    Route::prefix('overwork')->name('overwork.')->group(function () {
        Route::get('/form', [OverworkController::class, 'create'])->name('form-view');
        Route::post('/proccess', [OverworkController::class, 'store'])->name('insert');
        Route::get('/{overwork}/edit', [OverworkController::class, 'edit'])->name('edit');
        Route::put('/{overwork}', [OverworkController::class, 'update'])->name('update');
        Route::delete('/{overwork}', [OverworkController::class, 'destroy'])->name('delete');
        Route::get('/pending', [RequestController::class, 'showOverworkPending'])->name('pending');
        Route::get('/accepted', [RequestController::class, 'showOverworkAccepted'])->name('accepted');
        Route::get('/rejected', [RequestController::class, 'showOverworkRejected'])->name('rejected');
        Route::get('/draft', [RequestController::class, 'showOverworkDraft'])->name('draft');
    });
    
    //! leave
    Route::prefix('leave')->name('leave.')->group(function () {
        Route::get('/form', [LeaveController::class, 'create'])->name('form-view');
        Route::post('/proccess', [LeaveController::class, 'store'])->name('insert');
        Route::get('/{leave}/edit', [LeaveController::class, 'edit'])->name('edit');
        Route::put('/{leave}', [LeaveController::class, 'update'])->name('update');
        Route::delete('/{leave}', [LeaveController::class, 'destroy'])->name('delete');
        Route::get('/pending', [RequestController::class, 'showLeavePending'])->name('pending');
        Route::get('/accepted', [RequestController::class, 'showLeaveAccepted'])->name('accepted');
        Route::get('/rejected', [RequestController::class, 'showLeaveRejected'])->name('rejected');
        Route::get('/draft', [RequestController::class, 'showLeaveDraft'])->name('draft');
    });

    //! draft
    Route::get('/draft', [RequestController::class, 'showDraft'])->name('draft');

    //! recent
        Route::get('/recent', [RequestController::class, 'showRecent'])->name('recent');
    });

    //! overwork data (khusus untuk menampilkan data overwork)
    Route::get('/overwork-data', [RequestController::class, 'showOverworkData'])->name('overwork.data');
    
    //! leave data (khusus untuk menampilkan data leave)
    Route::get('/leave-data', [RequestController::class, 'showLeaveData'])->name('leave.data');
    
});

require __DIR__ . '/auth.php';
