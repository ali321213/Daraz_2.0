<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carts;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Carts::where('user_id', Auth::id())->with('product.images')->get();
        // $cart = Carts::where('user_id', Auth::id())->with(['product' => function ($query) {
        //     $query->with('images');
        // }])->get();
        return view('cart.index', compact('cart'));
    }

    // Add to cart
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Carts::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            // Add quantity to existing cart
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            // Create new cart entry
            Carts::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        // Return cart count in the response
        $cartCount = Carts::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cartCount' => $cartCount
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);
        $cart = Carts::findOrFail($request->id);
        $cart->update(['quantity' => $request->quantity]);
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    // public function add(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'quantity' => 'required|integer|min:1',
    //     ]);
    //     $cart = Carts::updateOrCreate(
    //         [
    //             'user_id' => Auth::id(),
    //             'product_id' => $request->product_id
    //         ],
    //         ['quantity' => $request->quantity]
    //     );
    //     return redirect()->back()->with('success', 'Product added to cart!');
    // }


    // Remove item from cart
    public function remove($id)
    {
        $cart = Carts::where('id', $id)->where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->delete();
            return redirect()->back()->with('success', 'Product removed from cart.');
        }
        return redirect()->back()->with('error', 'Item not found.');
    }
}
