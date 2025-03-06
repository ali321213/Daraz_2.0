<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* Display a listing of the resource */
    public function index()
    {
        // $brand = Brand::findOrFail($id);
        // $brands = Brand::all();
        return view('admin.brands.index');
    }

    public function show()
    {
        $brand = Brand::all();
        return response()->json($brand);
    }

    /* Show the form for creating a new resource */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'logo' => 'required'
        ]);
        $imagePaths = [];
        if ($request->hasFile('logo')) {
            foreach ($request->file('logo') as $image) {
                $path = $image->store('brands', 'public');
                $imagePaths[] = asset("storage/$path");
            }
        }
        $brand = Brand::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'logo' => json_encode($imagePaths)
        ]);
        return response()->json(['success' => 'Brand added successfully', 'Brand' => $brand]);
    }

    /* Store a newly created resource in storage */
    public function store(Request $request)
    {
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['error' => 'brand not found'], 404);
        }
        return response()->json($brand);
    }

    /* Update the specified resource in storage */
    public function update(Request $request, string $id)
    {
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        if ($brand->img) {
            Storage::delete(str_replace(asset('storage/'), '', $brand->logo));
        }
        $brand->delete();
        return response()->json(['success' => 'Brand deleted successfully']);
    }
}
