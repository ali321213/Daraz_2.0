<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Reviews;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function like(Request $request)
    {
        $review = Reviews::findOrFail($request->id);
        $review->increment('likes_count');
        return response()->json(['success' => true, 'likes' => $review->likes_count]);
    }
    public function dislike(Request $request)
    {
        $review = Reviews::findOrFail($request->id);
        $review->increment('dislikes_count');
        return response()->json(['success' => true, 'dislikes' => $review->dislikes_count]);
    }
    public function reply(Request $request)
    {
        $request->validate([
            'review_id' => 'required|exists:reviews,id',
            'reply' => 'required|string',
        ]);

        $reply = Reviews::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'review' => $request->reply,
            'parent_id' => $request->review_id,
        ]);

        return response()->json(['success' => true, 'reply' => $reply, 'message' => 'Reply submitted successfully.']);
    }
    public function replyForm(Request $request)
    {
        $review = Reviews::findOrFail($request->id);
        return view('products.partials.reply_form', compact('review'))->render();
    }
    public function replyList(Request $request)
    {
        $review = Reviews::with('replies.user')->findOrFail($request->id);
        return view('products.partials.reply_list', compact('review'))->render();
    }
    public function replyDelete(Request $request)
    {
        $reply = Reviews::findOrFail($request->id);
        if ($reply->user_id != Auth::id()) return response()->json(['error' => 'Unauthorized'], 403);
        $reply->delete();
        return response()->json(['success' => true, 'message' => 'Reply deleted successfully.']);
    }
    public function replyEdit(Request $request)
    {
        $reply = Reviews::findOrFail($request->id);
        if ($reply->user_id != Auth::id()) return response()->json(['error' => 'Unauthorized'], 403);
        return view('products.partials.reply_edit', compact('reply'))->render();
    }
    public function replyUpdate(Request $request)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);
        $reply = Reviews::findOrFail($request->id);
        if ($reply->user_id != Auth::id()) return response()->json(['error' => 'Unauthorized'], 403);
        $reply->update([
            'review' => $request->reply,
        ]);
        return response()->json(['success' => true, 'message' => 'Reply updated successfully.']);
    }
    public function create() {}

    public function upvote(Reviews $review)
    {
        $review->increment('upvotes');
        return response()->json(['success' => true, 'upvotes' => $review->upvotes]);
    }

    public function downvote(Reviews $review)
    {
        $review->increment('downvotes');
        return response()->json(['success' => true, 'downvotes' => $review->downvotes]);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'review' => 'required|string',
    //         'rating' => 'required|integer|min:1|max:5',
    //         'image' => 'nullable|image|max:2048'
    //     ]);
    //     $imagePath = null;
    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('reviews', 'public');
    //     }
    //     $review = Reviews::create([
    //         'user_id' => Auth::id(),
    //         'product_id' => $request->product_id,
    //         'review' => $request->review,
    //         'rating' => $request->rating,
    //         'image' => $imagePath,
    //         'parent_id' => $request->parent_id,
    //     ]);
    //     return response()->json(['success' => true, 'review' => $review, 'message' => 'Review submitted successfully.']);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|max:2048'
        ]);
        // Check if user actually ordered this product
        $hasOrdered = OrderItem::where('product_id', $request->product_id)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->exists();
        if (!$hasOrdered) {
            return response()->json(['error' => 'You can only review products you have purchased.'], 403);
        }
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }
        $review = Reviews::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'review' => $request->review,
            'rating' => $request->rating,
            'image' => $imagePath,
            'parent_id' => $request->parent_id ?? null,
        ]);
        return response()->json(['success' => true, 'review' => $review, 'message' => 'Review submitted successfully.']);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'review' => 'required|string',
    //         'rating' => 'required|integer|min:1|max:5',
    //         'image' => 'nullable|image|max:2048',
    //         'parent_id' => 'nullable|exists:reviews,id'
    //     ]);

    //     $imagePath = $request->hasFile('image') 
    //         ? $request->file('image')->store('reviews', 'public') 
    //         : null;

    //     $review = Reviews::create([
    //         'user_id' => Auth::id(),
    //         'product_id' => $request->product_id,
    //         'review' => $request->review,
    //         'rating' => $request->rating,
    //         'image' => $imagePath,
    //         'parent_id' => $request->parent_id,
    //     ]);
    //     return response()->json(['success' => true, 'review' => $review, 'message' => 'Review submitted successfully.']);
    // }

    public function update(Request $request, $id)
    {
        $review = Reviews::findOrFail($id);
        if ($review->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $request->validate([
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reviews', 'public');
            $review->image = $path;
        }

        $review->update([
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return response()->json(['success' => true, 'message' => 'Review updated']);
    }

    public function vote(Request $request)
    {
        $review = Reviews::findOrFail($request->id);
        if ($request->type == 'up') {
            $review->increment('upvotes');
        } else {
            $review->increment('downvotes');
        }

        return response()->json(['success' => true, 'upvotes' => $review->upvotes, 'downvotes' => $review->downvotes]);
    }

    public function destroy($id)
    {
        $review = Reviews::findOrFail($id);
        if ($review->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $review->delete();
        return response()->json(['success' => true, 'message' => 'Review deleted']);
    }
}