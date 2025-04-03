<?php

namespace App\Http\Controllers;

use App\Models\Brands;
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
        // $brands = Brands::paginate(3);
        $brands  = Brands::orderBy('created_at', 'DESC')->paginate(3);
            // $brands = Brands::all();
        // Uncomment and use this if you want to format the dates
        // $brands = $brands->map(function ($brand) {
        //     $brand->created_at_formatted = $brand->created_at->format('F j, Y, g:i a');
        //     $brand->updated_at_formatted = $brand->updated_at->format('F j, Y, g:i a');
        //     return $brand;
        // });
        return view('admin.brands.index', compact('brands'));
    }


    // public function show()
    // {
    //     $brands = Brands::all();
    //     $brands = $brands->map(function ($brand) {
    //         $brand->created_at_formatted = $brand->created_at->format('F j, Y, g:i a');
    //         $brand->updated_at_formatted = $brand->updated_at->format('F j, Y, g:i a');
    //         return $brand;
    //     });
    //     return response()->json($brands);
    // }

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
        $brand = Brands::create([
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
        $brand = Brands::find($id);
        if (!$brand) {
            return response()->json(['error' => 'brand not found'], 404);
        }
        return response()->json($brand);
    }

    /* Update the specified resource in storage */
    public function update(Request $request, string $id)
    {
        $brand = Brands::find($id);
        if (!$brand) {
            return redirect()->back()->with('error', 'Brand not found');
        }
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);
        // Handle logo upload if a new file is provided
        if ($request->hasFile('logo')) {
            // Delete the old logo
            if ($brand->logo && file_exists(public_path('storage/' . $brand->logo))) {
                unlink(public_path('storage/' . $brand->logo));
            }
            // Store the new logo
            $logoPath = $request->file('logo')->store('brands', 'public');
            $brand->logo = $logoPath;
        }
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->description = $request->description;
        $brand->save();
        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully');
    }

    public function destroy($id)
    {
        $brand = Brands::find($id);
        if ($brand) {
            if ($brand->logo && file_exists(public_path('storage/' . $brand->logo))) {
                unlink(public_path('storage/' . $brand->logo));
            }
            $brand->delete();
            return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully');
        }
        return redirect()->route('admin.brands.index')->with('error', 'Brand not found');
    }
}
