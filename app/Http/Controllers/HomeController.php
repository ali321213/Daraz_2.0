<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $banners = Banner::where('status', 1)->orderBy('position')->get();
        // return view('home', compact('banners'));
        $products = Product::all();
        return view('home', compact('products'));
        // return view('home');
    }
}