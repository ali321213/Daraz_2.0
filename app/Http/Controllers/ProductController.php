<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $products = Product::with(['brand', 'category', 'unit', 'images'])->get();
        // dd($products);
        return response()->json($products);
    }

    public function ProductDetails($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    // public function index()
    // {
    //     $brands = Brand::all();
    //     $categories = Category::all();
    //     $units = Unit::all();
    //     $products = Product::with('images')->get();
    //     return view('admin.products.index', compact('products', 'brands', 'categories', 'units'));
    // }

    public function index()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $units = Unit::all();
        return view('admin.products.index', compact('brands', 'categories', 'units'));
    }
    
    public function getProducts(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with(['unit', 'brand', 'category', 'images'])->select('products.*');
            return DataTables::of($products)
                ->addColumn('image', function ($product) {
                    if ($product->images->isNotEmpty()) {
                        return '<img src="' . asset('storage/' . $product->images->first()->image_path) . '" width="50" class="productImg" alt="Product Image">';
                    }
                    return '<span class="text-muted">No Image</span>';
                })->addColumn('actions', function ($product) {
                    return '<button class="btn btn-sm btn-info editBtn" data-id="' . $product->id . '" data-bs-toggle="modal" data-bs-target="#updateModal">Edit</button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $product->id . '">Delete</button>';
                })->rawColumns(['image', 'actions'])->make(true);
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit_id' => 'nullable|string|max:50',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'image_path.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        $product = Product::create($request->only([
            'name',
            'description',
            'price',
            'unit_id',
            'brand_id',
            'category_id',
            'stock'
        ]));
        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $image) {
                $imagePath = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath // Ensure column name matches database schema
                ]);
            }
        }
        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required',
            'brand_id' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $product = Product::findOrFail($id);
        // Delete Old Images
        if ($request->hasFile('image_path')) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path); // Delete from storage
                $image->delete(); // Delete from database
            }
            // Save New Images
            foreach ($request->file('image_path') as $image) {
                $imgPath = $image->store('product_images', 'public'); // Save to storage
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imgPath // Ensure correct column name
                ]);
            }
        }
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id
        ]);
        return response()->json(['success' => 'Product updated successfully', 'product' => $product]);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    // public function destroy($id)
    // {
    //     $product = Product::findOrFail($id);
    //     foreach ($product->images as $image) {
    //         Storage::delete('public/' . $image->image_path);
    //         $image->delete();
    //     }
    //     $product->delete();
    //     return response()->json(['success' => 'Product deleted successfully']);
    // }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        foreach ($product->images as $image) {
            // Ensure correct path (remove "public/" prefix)
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }
        $product->delete();

        return response()->json(['success' => 'Product deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = $request->query('query');
        $products = Product::with(['brand', 'category', 'unit'])
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhereHas('brand', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('unit', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
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