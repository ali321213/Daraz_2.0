<?php

namespace App\Http\Controllers;
use App\Models\Brands;
use App\Models\Category;
use App\Models\Products;
use App\Models\Unit;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        $products = Products::with(['images', 'brand', 'category', 'unit'])->get();
        $brands = Brands::all();
        $categories = Category::all();
        $units = Unit::all();
        return view('admin.home', compact('products', 'brands', 'categories', 'units'));
    }
}