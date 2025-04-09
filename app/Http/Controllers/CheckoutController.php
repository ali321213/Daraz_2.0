<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $country = Country::where('iso2', 'PK')->first();
        $states = $country ? $country->states : collect();
        $cities = City::whereIn('state_id', $states->pluck('id'))->get();
        return view('checkout');
        return view('checkout.index', compact('country', 'states', 'cities'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email',
            'address_line' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Store order (example)
        Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'address' => $request->address_line,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'address_line' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:cod,card',
        ]);
        $address = Addresses::create([
            'user_id' => Auth::id(), // user must be logged in
            'address_line' => $request->address_line,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => 'Pakistan',
            'type' => 'shipping',
        ]);
        // You can now attach this address to an order
        // (just an example, assuming you have an Order model)
        // Order::create([...])
        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }
}
