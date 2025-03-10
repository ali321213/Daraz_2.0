<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductImage;
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
        $products = Product::all()->map(
            function ($product) {
                $product->img = json_decode($product->img, true) ?? [];
                return $product;
            }
        );
        return response()->json($products);
    }

    public function ProductDetails($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function index()
    {
        $brands = Brand::all();
        $category = Category::all();
        $products = Product::with('images')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product = Product::create($request->only([
            'name',
            'description',
            'price',
            'unit',
            'brand_id',
            'category_id',
            'stock'
        ]));
        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $image) {
                $imagePath = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath
                ]);
            }
        }
        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    // public function create(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'price' => 'required|numeric',
    //         'brand' => 'required',
    //         'unit' => 'required',
    //         'category' => 'required',
    //         'img' => 'required',
    //         'img.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240'
    //     ]);
    //     $imagePaths = [];
    //     if ($request->hasFile('img')) {
    //         foreach ($request->file('img') as $image) {
    //             $path = $image->store('products', 'public');
    //             $imagePaths[] = asset("storage/$path");
    //         }
    //     }
    //     $product = Product::create([
    //         'name' => $request->name,
    //         'price' => $request->price,
    //         'brand' => $request->brand,
    //         'unit' => $request->unit,
    //         'category' => $request->category,
    //         'img' => json_encode($imagePaths)
    //     ]);
    //     return response()->json(['success' => 'Product added successfully', 'product' => $product]);
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'brand' => 'required',
            'unit' => 'required',
            'category' => 'required',
            'img.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'price' => 'required|numeric',
    //         'brand' => 'required',
    //         'unit' => 'required',
    //         'category' => 'required',
    //         'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    //     ]);
    //     // Store image in public storage
    //     $imgPath = $request->file('img')->store('products', 'public');
    //     // Create new product
    //     $product = Product::create([
    //         'name' => $request->name,
    //         'price' => $request->price,
    //         'brand' => $request->brand,
    //         'unit' => $request->unit,
    //         'category' => $request->category,
    //         'img' => asset("storage/$imgPath")
    //     ]);
    //     return response()->json(['success' => 'Product added successfully', 'product' => $product]);
    // }
}