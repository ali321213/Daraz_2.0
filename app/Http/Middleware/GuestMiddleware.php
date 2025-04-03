<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestMiddleware {
    public function handle(Request $request, Closure $next) {
        if (Auth::check()) {
            return redirect()->route('home')->with('message', 'You are already logged in.');
        }
        return $next($request);
    }
}
