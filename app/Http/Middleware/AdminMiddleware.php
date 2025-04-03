<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware {
    public function handle(Request $request, Closure $next) {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Access Denied! Admins Only.');
        }
        return $next($request);
    }
}
