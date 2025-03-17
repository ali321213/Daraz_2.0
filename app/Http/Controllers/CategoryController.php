<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
        // $categories = Category::latest()->paginate(5);
        // return view('admin.categories.index',compact('categories'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'required|string|unique:categories,slug',
            'image' => 'nullable|image|max:10240',
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->slug = \Str::slug($request->slug);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }
        $category->save();
        return response()->json([
            'success' => true,
            'message' => 'Category created successfully!',
            'category' => $category
        ]);
    }
    

    public function edit($id)
    {
        $category = Category::findOrFail($id);
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
        $category = Category::findOrFail($id);
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
        $category = Category::findOrFail($id);
        if ($category->image) {
            \Storage::delete('public/' . $category->image);
        }
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully!');
    }
}