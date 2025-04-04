@extends('layouts.app')
@section('content')
@section('title', 'Daraz_2.O')
<div class="container">
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner"></div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>

<div class="container">
    <!-- Categories -->
    <div class="container mt-5">
        <h2 class="mt-5 pb-3 fw-bold">Shop by Category:</h2>
        <div class="row justify-content-center">
            @foreach($categories as $category)
            <div class="col-lg-2 col-md-3 col-6 text-center CategoryCard">
                <a href="{{ url('/category/' . $category->slug) }}" class="category-box text-decoration-none text-dark text-capitalize">
                    <img src="{{ asset('storage/' . $category->image) }}" class="category-img" alt="{{ $category->name }}">
                    <p class="mt-3 h4">{{ $category->name }}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Products Section -->
    <div class="container mt-5">
        <div class="row d-flex align-items-center">
            <div class="col-lg-12">
                <h2 class="my-3 fw-bold">Our Products:</h2>
            </div>
        </div>

        <!-- Product Listing -->
        <div class="row">
            @foreach ($products as $product)
            <div class="col-lg-3 col-md-6 col-sm-12 col-12 mb-4">
                <div class="product-card">
                    <!-- Product Image -->
                    @if($product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                    <img src="{{ asset('assets/images/one.jpg') }}" class="card-img-top" alt="No Image">
                    @endif
                    <p class="mt-3 h3">{{ $product->name }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <p class="text-danger h2">Rs. {{ number_format($product->price) }}</p>
                            <span class="discount-badge mt-5">-40% Discount</span>
                        </div>
                        <div>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <div type="submit"><i class="bi bi-cart-plus headerIcons" style="font-size: 37px;font-weight:800;"></i></div>
                            </form>
                        </div>
                    </div>
                    <a href="{{ route('products.detail', $product->id) }}" class="btn btn-primary mt-3">View Details</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- <div class="container mt-4">
    <div class="row">
        <div class="col-md-3 col-lg-3 col-12">
            <div class="product-card">
                <img src="{{ asset('assets/images/one.jpg') }}" class="product-img" alt="Product">
                <p class="fw-bold mt-2 h5">Plain Summer Track Suits for Men & Women - Export Quality</p>
                <div class="d-flex justify-content-center align-items-center mt-3">
                    <p class="fw-bold h4 text-danger m-0">Rs. 723</p>
                    <span class="discount-badge ms-2">-40%</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-12">
            <div class="product-card">
                <img src="{{ asset('assets/images/one0.jpg') }}" class="product-img" alt="Product">
                <p class="fw-bold mt-2 h5">Premium Winter Hoodies for Men & Women</p>
                <div class="d-flex justify-content-center align-items-center mt-3">
                    <p class="fw-bold h4 text-danger m-0">Rs. 999</p>
                    <span class="discount-badge ms-2">-30%</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-12">
            <div class="product-card">
                <img src="{{ asset('assets/images/one1.jpg') }}" class="product-img" alt="Product">
                <p class="fw-bold mt-2 h5">Casual Sneakers - Lightweight & Comfortable</p>
                <div class="d-flex justify-content-center align-items-center mt-3">
                    <p class="fw-bold h4 text-danger m-0">Rs. 1,299</p>
                    <span class="discount-badge ms-2">-25%</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-12">
            <div class="product-card">
                <img src="{{ asset('assets/images/one2.jpg') }}" class="product-img" alt="Product">
                <p class="fw-bold mt-2 h5">Casual Sneakers - Lightweight & Comfortable</p>
                <div class="d-flex justify-content-center align-items-center mt-3">
                    <p class="fw-bold h4 text-danger m-0">Rs. 1,299</p>
                    <span class="discount-badge ms-2">-25%</span>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection