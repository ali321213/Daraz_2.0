<?php

namespace App\Http\Controllers;

use App\Models\Brand;
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
        // return view('brands.index', compact('brand'));
        return view('brands.index');
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

    /* Display the specified resource */
    public function show(string $id)
    {
    }

    /* Show the form for editing the specified resource */
    public function edit(string $id)
    {
    }

    /* Update the specified resource in storage */
    public function update(Request $request, string $id)
    {
    }

    /* Remove the specified resource from storage */
    public function destroy(string $id)
    {
    }
}