@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-lg-12 col-md-12 col-12 text-center">
            <h1 class="fw-bold">Welcome to Daraz 2.0</h1>
            <p>Browse our latest products!</p>

            <a href="{{ route('products.index') }}" class="btn btn-primary">Shop Now</a>
            <!-- <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
                </div>
            </div> -->
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-12">
            <h2 class="mb-4 fw-bold">Our Products:-</h2>
                @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $product->img }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">
                                <strong>Brand:</strong> {{ $product->brand }} <br>
                                <strong>Category:</strong> {{ $product->category }} <br>
                                <strong>Unit:</strong> {{ $product->unit }} <br>
                                <strong>Price:</strong> ${{ number_format($product->price, 2) }}
                            </p>
                            <a href="{{ route('detail', $product->id) }}" class="btn btn-primary">View Details</a><a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Details</a>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
</div>
@endsection