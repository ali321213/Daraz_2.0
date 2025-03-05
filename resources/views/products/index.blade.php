@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <h1>All Products</h1>
    <div class="product-list">
        @foreach($products as $product)
            <div class="product">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                <h2>{{ $product->name }}</h2>
                <p>${{ $product->price }}</p>
                <a href="{{ route('products.show', $product->id) }}">View Details</a>
            </div>
        @endforeach
    </div>
@endsection
