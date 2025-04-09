<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestMiddleware {
    public function handle(Request $request, Closure $next) {
        // Redirect authenticated users away from guest-only routes
        if (Auth::check()) {
            return redirect()->route('/');
        }
        return $next($request);
    }
}