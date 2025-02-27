<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $products = Product::all();
        // return view('product');
        // return view('product', compact('products'));
        return response()->json($products);
    }

    public function products()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }


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

    // public function show()
    // {
    //     $products = Product::all();
    //     return response()->json($products);
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'brand' => 'required',
            'unit' => 'required',
            'category' => 'required',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $product = Product::findOrFail($id);
        if ($request->hasFile('img')) {
            if ($product->img) {
                Storage::delete(str_replace(asset('storage/'), '', $product->img));
            }
            $imgPath = $request->file('img')->store('products', 'public');
            $product->img = asset("storage/$imgPath");
        }
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'brand' => $request->brand,
            'unit' => $request->unit,
            'category' => $request->category,
        ]);
        return response()->json(['success' => 'Product updated successfully', 'product' => $product]);
    }

    public function edit_product($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->img) {
            Storage::delete(str_replace(asset('storage/'), '', $product->img));
        }
        $product->delete();
        return response()->json(['success' => 'Product deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = $request->query('query');
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('brand', 'LIKE', "%{$query}%")
            ->orWhere('category', 'LIKE', "%{$query}%")
            ->get();
        return response()->json($products);
    }
}