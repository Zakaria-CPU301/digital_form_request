<?php

use App\Http\Middleware\ActiveAccount;
use App\Http\Middleware\CheckLeaveBalance;
use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckSuspended;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware global
        $middleware->alias([
            'role' => CheckRole::class,
            'suspended' => CheckSuspended::class,
            'balance' => CheckLeaveBalance::class,
            'active' => ActiveAccount::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
