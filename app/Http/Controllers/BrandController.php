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

    public function index()
    {
        // $brands = Brand::all();
        return view('admin.brands.index');
        // , compact('brands')
    }

    public function show()
    {
        $brands = Brand::all();
        $brands = $brands->map(function ($brand) {
            $brand->created_at_formatted = $brand->created_at->format('F j, Y, g:i a');
            $brand->updated_at_formatted = $brand->updated_at->format('F j, Y, g:i a');
            return $brand;
        });
        return response()->json($brands);
    }

    /* Show the form for creating a new resource */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);
        $logoPath = '';
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('brands', 'public');
        }
        $brand = Brand::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'logo' => $logoPath
        ]);
        return response()->json(['success' => 'Brand added successfully', 'Brand' => $brand]);
    }


    public function store(Request $request) {}

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
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['error' => 'Brand not found'], 404);
        }
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);
        // Handle logo upload if a new file is provided
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('brands', 'public');
            $brand->logo = $logoPath;
        }
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->description = $request->description;
        $brand->save();

        return response()->json(['success' => 'Brand updated successfully', 'brand' => $brand]);
    }


    public function destroy($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $brand->delete();
            return response()->json(['success' => 'Brand deleted successfully']);
        }
        return response()->json(['error' => 'Brand not found'], 404);
    }
}
