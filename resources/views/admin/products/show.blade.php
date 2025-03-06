@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <img src="{{ $product->img }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h2 class="card-title">{{ $product->name }}</h2>
                    <p class="card-text">
                        <strong>Brand:</strong> {{ $product->brand }} <br>
                        <strong>Category:</strong> {{ $product->category }} <br>
                        <strong>Unit:</strong> {{ $product->unit }} <br>
                        <strong>Price:</strong> ${{ number_format($product->price, 2) }}
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Back to Products</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
