@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <h1>Your Shopping Cart</h1>

    @if($cart->count() > 0)
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            @foreach($cart as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>${{ $item->product->price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ $item->product->price * $item->quantity }}</td>
                </tr>
            @endforeach
        </table>

        <a href="{{ route('checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
    @else
        <p>Your cart is empty.</p>
    @endif
@endsection
