<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::where('status', 1)->orderBy('position')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'position' => 'nullable|integer',
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
            'link' => $request->link,
            'position' => $request->position ?? 1,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner added successfully!');
    }

    public function edit($id)
    {
        $category = Banner::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'required|string|unique:categories,slug,' . $id,
            'image' => 'nullable|image|max:2048',
        ]);
        $category = Banner::findOrFail($id);
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && \Storage::exists('public/' . $category->image)) {
                \Storage::delete('public/' . $category->image);
            }
            // Store new image
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }
        // Update category details
        $category->fill([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => \Str::slug($request->slug), // Convert slug to proper format
        ]);
        $category->save(); // Save changes to DB
        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully!',
            'category' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Banner::findOrFail($id);
        if ($category->image) {
            \Storage::delete('public/' . $category->image);
        }
        $category->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Category deleted successfully!');
    }

    public function toggleStatus(Request $request)
    {
        $banner = Banner::findOrFail($request->id);
        $banner->status = $request->status;
        $banner->save();
        return response()->json(['success' => true, 'message' => 'Banner status updated successfully!']);
    }

    public function search(Request $request)
    {
        $query = $request->query('query');
        $products = Brand::with(['brand', 'category', 'unit'])->where('name', 'LIKE', "%{$query}%")->orWhereHas('brand', function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        })->orWhereHas('unit', function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        })->orWhereHas('category', function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        })->get();
        return response()->json($products);
    }
}