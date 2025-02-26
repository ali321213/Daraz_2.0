<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('product');
    }

    public function create() {}
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'brand' => 'required',
            'unit' => 'required',
            'category' => 'required',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        // Store image in public storage
        $imgPath = $request->file('img')->store('products', 'public');
        // Create new product
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'brand' => $request->brand,
            'unit' => $request->unit,
            'category' => $request->category,
            'img' => asset("storage/$imgPath")
        ]);

        return response()->json(['success' => 'Product added successfully', 'product' => $product]);
    }

    public function show()
    {
        $products = Product::all();
        return response()->json($products);
    }
    public function edit(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'brand' => 'required',
            'unit' => 'required',
            'category' => 'required',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('products', 'public');
            $product->img = asset("storage/$imgPath");
        }
        $product->update($request->only(['name', 'price', 'brand', 'unit', 'category']));
        return response()->json(['success' => 'Product updated successfully', 'product' => $product]);
    }
    public function update(Request $request, string $id) {}
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['success' => 'Product deleted successfully']);
    }
}
