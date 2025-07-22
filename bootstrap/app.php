<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DriverMiddleware;
use App\Http\Middleware\StaffMiddleware;
use App\Http\Middleware\User;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'verify' => \App\Http\Middleware\VerifyEmail::class,
            'admin' => AdminMiddleware::class,
            'user' => User::class,
            'staff' => StaffMiddleware::class,
            'driver' => DriverMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
