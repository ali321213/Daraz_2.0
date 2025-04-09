<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Category;
use App\Models\Banners;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Cart;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $banners = Banners::where('status', 1)->orderBy('position')->get();
        $products = Product::with(['images', 'brand', 'category', 'unit'])->get();
        $brands = Brands::all();
        $carts = Cart::all();
        $categories = Category::all();
        $units = Unit::all();
        return view('home', compact('products', 'brands', 'categories', 'units', 'carts', 'banners'));
    }
}