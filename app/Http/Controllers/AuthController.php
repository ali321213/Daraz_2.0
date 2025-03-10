<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    use AuthenticatesUsers;
    protected $redirectTo = '/product';

    public function signin()
    {
        return view('auth.login');
    }

    public function signup()
    {
        return view('auth.register');
    }
}
