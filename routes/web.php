<?php

use App\Models\User;
use App\Models\Leave;
use Illuminate\Http\Request;
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

Route::middleware(['active'])->group(function () {
    Route::prefix('info')->name('info.')->group(function () {
        Route::get('/account-suspended', function () {
            return view('suspended');
        })->name('account-suspended');
    });
});

Route::middleware(['auth', 'verified', 'suspended'])->group(function () {
    Route::get('leave_allowance', function (Request $request) {
        if (!$request->expectsJson()) {
            abort(403, 'Forbidden');
        }
        $user = Auth::user()->id;
        $allowance = User::findOrFail($user)->overwork_allowance;
        $total = Leave::where('user_id', $user)->where('request_status', 'approved')->sum('leave_period');

        return response()->json([
            'leave_allowance' => $allowance,
            'leave_period' => $total
        ]);
    });

    //! dashboard
    Route::match(['get', 'post'], '/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('destroy');
    });

    //! manage data
    Route::middleware('role:admin')->group(function () {
        Route::prefix('request')->name('request.')->group(function () {
            Route::get('/data', [ManageDataController::class, 'show'])->name('show');
            Route::match(['get', 'post'], 'edit/{id}/{userId}', [ManageDataController::class, 'edit'])->name('edit');
        });
        Route::prefix('account')->name('account.')->group(function () {
            Route::get('/', [ManageAccountController::class, 'show'])->name('show');
            Route::get('edit/user/{id}/status/{status?}', [ManageAccountController::class, 'edit'])->name('edit');
            Route::get('delete/{id}', [ManageAccountController::class, 'destroy'])->name('delete');
        });
    });

    //! draft
    Route::get('/draft', [RequestController::class, 'showDraft'])->name('draft')->middleware('role:user');

    //! overwork
    Route::prefix('overwork')->name('overwork.')->group(function () {
        Route::middleware(['auth', 'role:user'])->group(function () {
            Route::get('/form', [OverworkController::class, 'create'])->name('form-view');
            Route::post('/proccess', [OverworkController::class, 'store'])->name('insert');
            Route::get('/{overwork}/edit', [OverworkController::class, 'edit'])->name('edit');
            Route::put('/{overwork}', [OverworkController::class, 'update'])->name('update');
            Route::delete('/{overwork}', [OverworkController::class, 'destroy'])->name('delete');
            Route::delete('/evidence/{evidence}', [OverworkController::class, 'deleteEvidence'])->name('evidence.delete');
        });
        Route::get('/', [RequestController::class, 'showRecent'])->name('show');
    });

    //! leave
    Route::prefix('leave')->name('leave.')->group(function () {
        Route::middleware(['auth', 'role:user'])->group(function () {
            Route::middleware(['auth', 'balance'])->group(function () {
                Route::get('/form', [LeaveController::class, 'create'])->name('form-view');
            });
            Route::match(['get', 'post'], '/proccess', [LeaveController::class, 'store'])->name('insert');
            Route::get('/{leave}/edit', [LeaveController::class, 'edit'])->name('edit');
            Route::put('/{leave}', [LeaveController::class, 'update'])->name('update');
            Route::delete('/{leave}', [LeaveController::class, 'destroy'])->name('delete');
        });
        Route::get('/', [RequestController::class, 'showRecent'])->name('show');
    });
});

require __DIR__ . '/auth.php';
