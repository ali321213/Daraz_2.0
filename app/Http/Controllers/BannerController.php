<?php

namespace App\Http\Controllers;

use App\Models\Banner;
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
            'status' => 'required|boolean',
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
            'link' => $request->link,
            'position' => $request->position ?? 1,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner added successfully!');
    }
}