<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Category;
use App\Models\Banners;
use App\Models\Products;
use App\Models\Unit;
use App\Models\Carts;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $banners = Banners::where('status', 1)->orderBy('position')->get();
        $products = Products::with(['images', 'brand', 'category', 'unit'])->get();
        $brands = Brands::all();
        $carts = Carts::all();
        $categories = Category::all();
        $units = Unit::all();
        return view('home', compact('products', 'brands', 'categories', 'units', 'carts', 'banners'));
    }

    public function adminDashboard()
    {
        $products = Products::with(['images', 'brand', 'category', 'unit'])->get();
        $brands = Brands::all();
        $categories = Category::all();
        $units = Unit::all();
        return view('admin.home', compact('products', 'brands', 'categories', 'units'));
    }
}
