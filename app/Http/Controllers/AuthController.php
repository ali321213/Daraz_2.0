<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function signin()
    {
        return view('auth.login');
    }

    public function signup()
    {
        return view('auth.register');
    }
}