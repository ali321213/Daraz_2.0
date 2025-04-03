@extends('layouts.app')
@section('content')
@section('title', 'Shopping Cart')
<div class="container mt-5">
    <h1 class="fw-bold mb-4">Your Shopping Cart</h1>

    @if($cart->count() > 0)
        <table class="table table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                <tr>
                    <td class="align-middle">{{ $item->product->name }}</td>
                    <td class="align-middle">
                        @if($item->product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" alt="{{ $item->product->name }}" width="70">
                        @else
                            <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="No Image" width="70">
                        @endif
                    </td>
                    <td class="align-middle">Rs. {{ number_format($item->product->price) }}</td>
                    <td class="align-middle">
                        <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control w-50 d-inline">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                    <td class="align-middle">Rs. {{ number_format($item->product->price * $item->quantity) }}</td>
                    <td class="align-middle">
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Clear Cart</button>
            </form>

            <a href="{{ route('home') }}" class="btn btn-secondary">Continue Shopping</a>
            <a href="{{ route('checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    @else
        <p class="alert alert-warning text-center">Your cart is empty.</p>
        <div class="text-center">
            <a href="{{ route('home') }}" class="btn btn-secondary">Shop Now</a>
        </div>
    @endif
</div>


<!-- resources/views/payment/jazzcash.blade.php -->

<form name="redirect-to-payment-gateway" method="POST" action="{{ config('jazzcash.' . config('jazzcash.environment') . '.endpoint') }}">
    @foreach($data as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
</form>
<script>
    document.forms['redirect-to-payment-gateway'].submit();
</script>

@endsection