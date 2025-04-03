<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'payment_method' => 'required'
        ]);

        $cartItems = Auth::user()->carts;

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $order = Orders::create([
            'user_id' => Auth::id(),
            'total_price' => $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            }),
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'status' => 'pending'
        ]);

        foreach ($cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        $cartItems->each->delete();

        return redirect()->route('home')->with('success', 'Order placed successfully.');
    }
}
