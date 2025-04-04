<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     Reviews::create([
    //         'user_id' => auth()->id(),
    //         'product_id' => $request->product_id,
    //         'review' => $request->review,
    //         'rating' => $request->rating,
    //         'parent_id' => $request->parent_id,
    //     ]);

    //     return response()->json(['success' => true, 'message' => 'Review added successfully']);
    // }

    // public function upvote(Reviews $review)
    // {
    //     $review->increment('upvotes');
    //     return response()->json(['success' => true, 'upvotes' => $review->upvotes]);
    // }

    // public function downvote(Reviews $review)
    // {
    //     $review->increment('downvotes');
    //     return response()->json(['success' => true, 'downvotes' => $review->downvotes]);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Reviews::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'review' => $request->review,
            'rating' => $request->rating,
            'parent_id' => $request->parent_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Review submitted successfully.']);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
