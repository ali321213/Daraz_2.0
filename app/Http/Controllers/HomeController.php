<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home_index()
    {
        $banners = Banner::where('status', 1)->orderBy('position')->get();
        return view('home', compact('banners'));
    }
}