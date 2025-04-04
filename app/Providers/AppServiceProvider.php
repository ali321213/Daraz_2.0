<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\GuestMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /* Register any application services */
    public function register(): void {}

    /* Bootstrap any application services */
    public function boot(): void
    {
        Route::middlewareGroup('auth', [AuthMiddleware::class]);
        Route::middlewareGroup('admin', [AdminMiddleware::class]);
        Route::middlewareGroup('customer', [CustomerMiddleware::class]);
        Route::middlewareGroup('guest', [GuestMiddleware::class]);
    }
}