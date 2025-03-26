@extends('layouts.app')
@section('content')
<div class="container">
    <!-- Banner Slider -->
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner"></div>
        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="fw-bold">Welcome to Daraz 2.0</h1>
            <!-- <p>Browse our latest products!</p> -->
        </div>
    </div>

    <!-- Categoeries -->
    <div class="container mt-5">
        <!-- <h3 class="text-center mb-4">Shop by Category</h3> -->
        <h2 class="mt-5 pb-3 fw-bold">Shop by Category:-</h2>
        <div class="row justify-content-center">
            <div class="col-lg-2 col-md-3 col-6 text-center">
                <a href="{{ url('/category/men') }}" class="category-box text-decoration-none text-dark">
                    <img src="{{ asset('assets/images/category.jpg') }}" class="category-img" alt="Men's Fashion">
                    <p class="mt-3 fw-bold h4">Men's Fashion</p>
                </a>
            </div>
            <div class="col-lg-2 col-md-3 col-6 text-center">
                <a href="{{ url('/category/women') }}" class="category-box text-decoration-none text-dark">
                    <img src="{{ asset('assets/images/category0.jpg') }}" class="category-img" alt="Women's Fashion">
                    <p class="mt-3 fw-bold h4">Women's Fashion</p>
                </a>
            </div>
            <div class="col-lg-2 col-md-3 col-6 text-center">
                <a href="{{ url('/category/electronics') }}" class="category-box text-decoration-none text-dark">
                    <img src="{{ asset('assets/images/category4.jpg') }}" class="category-img" alt="Electronics">
                    <p class="mt-3 fw-bold h4">Electronics</p>
                </a>
            </div>
            <div class="col-lg-2 col-md-3 col-6 text-center">
                <a href="{{ url('/category/shoes') }}" class="category-box text-decoration-none text-dark">
                    <img src="{{ asset('assets/images/category2.jpg') }}" class="category-img" alt="Shoes">
                    <p class="mt-3 fw-bold h4">Shoes</p>
                </a>
            </div>
            <div class="col-lg-2 col-md-3 col-6 text-center">
                <a href="{{ url('/category/watches') }}" class="category-box text-decoration-none text-dark">
                    <img src="{{ asset('assets/images/category3.webp') }}" class="category-img" alt="Watches">
                    <p class="mt-3 fw-bold h4">Watches</p>
                </a>
            </div>
            <hr>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <!-- <input type="search" id="searchProducts" class="form-control form-control-lg" placeholder="Search Products"> -->
            <h2 class="my-3 fw-bold">Our Products:-</h2>
        </div>
        <div class="col-lg-6">
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary float-end">Shop Now</a>
        </div>
    </div>
</div>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-12">
            @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($product->images->isNotEmpty())
                    <img src="{{ asset($product->images->first()->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                    <img src="{{ asset('images/default.png') }}" class="card-img-top" alt="No Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">
                            <strong>Brand:</strong> {{ $product->brand->name ?? 'N/A' }} <br>
                            <strong>Category:</strong> {{ $product->category->name ?? 'N/A' }} <br>
                            <strong>Unit:</strong> {{ $product->unit->name ?? 'N/A' }} <br>
                            <strong>Price:</strong> ${{ number_format($product->price, 2) }}
                        </p>
                        <a href="{{ route('products.detail', $product->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Product Listing -->
<div class="container mt-4">
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-3 col-lg-3 col-12">
            <div class="product-card">
                <img src="{{ asset('storage/' . $product->images->first()->path ?? 'default.jpg') }}" class="product-img" alt="{{ $product->name }}">
                <p class="fw-bold mt-2 h5">{{ $product->name }}</p>
                <strong>Brand:</strong><p class="fw-bold mt-2 h5">{{ $product->brand->name }}</p>
                <div class="d-flex justify-content-center align-items-center mt-3">
                <p class="fw-bold h6 text-danger m-0">Rs. {{ number_format($product->price) }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>



<div class="container mt-4">
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



</div>


<div class="container mt-4">
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



</div>
<div class="container mt-4">
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
</div>
@endsection