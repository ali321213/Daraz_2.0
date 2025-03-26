<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $banners = Banner::where('status', 1)->orderBy('position')->get();
        $products = Product::with(['images', 'brand', 'category', 'unit'])->get();
        $brands = Brand::all();
        $categories = Category::all();
        $units = Unit::all();
        return view('home', compact('products', 'brands', 'categories', 'units', 'banners'));
    }
}