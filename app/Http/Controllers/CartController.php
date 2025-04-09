<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->with('product.images')->get();
        return view('cart.index', compact('cart'));
    }

    // Add to cart
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            // Add quantity to existing cart
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            // Create new cart entry
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        // Return cart count in the response
        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cartCount' => $cartCount
        ]);
    }

    public function updateCart(Request $request)
    {
        $cartItem = Cart::where('id', $request->id)->where('user_id', auth()->id())->first();
        if ($cartItem) {
            $cartItem->update(['quantity' => $request->quantity]);
        }
        return redirect()->back()->with('success', 'Product Updated in cart');
    }

    public function calculateCartTotal()
    {
        $cart = auth()->user()->carts()->with('product')->get();
        $subtotal = $cart->sum(fn($item) => $item->product->price * $item->quantity);
        $tax = $subtotal * 0.1; // Example: 10% tax
        $shipping = 200; // Example: Flat rate shipping
        $total = $subtotal + $tax + $shipping;

        return response()->json([
            'subtotal' => number_format($subtotal, 2),
            'tax' => number_format($tax, 2),
            'shipping' => number_format($shipping, 2),
            'total' => number_format($total, 2)
        ]);
    }

    // Remove item from cart
    // public function remove($id)
    // {
    //     $cart = Cart::where('id', $id)->where('user_id', Auth::id())->first();
    //     if ($cart) {
    //         $cart->delete();
    //         return redirect()->back()->with('success', 'Product removed from cart');
    //     }
    //     return redirect()->back()->with('error', 'Item not found.');
    // }

    // public function clear()
    // {
    //     $user = Auth::user();

    //     if ($user) {
    //         Cart::where('user_id', $user->id)->delete();
    //         return redirect()->route('cart.index')->with('success', 'Cart has been cleared.');
    //     }

    //     return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
    // }

    public function updateAll(Request $request)
    {
        foreach ($request->quantities as $id => $qty) {
            $cartItem = Auth::user()->carts()->find($id);
            if ($cartItem) {
                $cartItem->update(['quantity' => $qty]);
            }
        }
        return response()->json(['success' => true, 'message' => 'Cart updated successfully.']);
    }


    public function remove(Request $request)
    {
        $cart = Cart::where('id', $request->id)->where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->delete();
        }
        $cart = Auth::user()->carts()->with('product.images')->get();
        $html = view('cart._cart', compact('cart'))->render();
        return response()->json(['html' => $html]);
    }


    public function clear()
    {
        Auth::user()->carts()->delete();
        $cart = collect();
        return redirect()->back()->with('success', 'Cart cleared successfully!');
        // return response()->json(['success' => true, 'message' => 'Cart cleared successfully.']);
    }

    // public function add(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'quantity' => 'required|integer|min:1',
    //     ]);
    //     $cart = Cart::updateOrCreate(
    //         [
    //             'user_id' => Auth::id(),
    //             'product_id' => $request->product_id
    //         ],
    //         ['quantity' => $request->quantity]
    //     );
    //     return redirect()->back()->with('success', 'Product added to cart!');
    // }

    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|exists:carts,id',
    //         'quantity' => 'required|integer|min:1'
    //     ]);
    //     $cart = Cart::findOrFail($request->id);
    //     $cart->update(['quantity' => $request->quantity]);
    //     return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    // }
}
