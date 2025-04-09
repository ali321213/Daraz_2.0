<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\GuestMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Exceptions\Handler as ExceptionsHandler;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )->withMiddleware(function ($middleware) { // Removed incorrect type-hint
        $middleware->alias([
            'guest' => GuestMiddleware::class,
            'admin' => AdminMiddleware::class,
            'auth' => AuthMiddleware::class,
            'subscribed' => CheckUserRole::class,
        ]);
    })->withExceptions(function () {})->create();