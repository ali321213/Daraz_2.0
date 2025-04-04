<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware {
    public function handle(Request $request, Closure $next) {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
        return $next($request);
    }
}