@extends('layouts.app')
@section('content')
@section('title', $product->name . ' - Product Details')
<div class="container mt-5">
    <div class="row d-flex align-items-center">
        <div class="col-lg-12 mb-4">
            <h1 class="fw-bold">Product Details</h1>
            <p class="text-muted">Explore the details of our product.</p>
        </div>
    </div>
    <div class="row d-flex align-items-center">
        <!-- Product Image -->
        <div class="col-md-3">
            @if($product->images->isNotEmpty())
            <!-- <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="img-fluid" alt="{{ $product->name }}"> -->
            <img src="{{ asset('assets/images/category3.webp') }}" class="img-fluid" alt="No Image Available">
            @else
            <img src="{{ asset('assets/images/category1.webp') }}" class="img-fluid" alt="No Image Available">
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-md-6 text-capitalize">
            <div class="float-end">
                <i class="bi bi-share" style="font-size: 32px;margin-right:20px;"></i>
                <i class="bi bi-heart wishlist" style="font-size: 32px;"></i>
            </div>
            <h1 class="fw-bold">{{ $product->name }}</h1>
            <p class="text-muted">Category: {{ $product->category->name ?? 'Uncategorized' }}</p>
            <h3 class="text-danger">Rs. {{ number_format($product->price) }}</h3>
            <p class="mt-3">{{ $product->description }}</p>
            <!-- Quantity & Color Variant Selection -->
            <form id="addToCartForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <label for="quantity" class="fw-bold">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control w-50 mb-2">
                @if($product->variants->isNotEmpty())
                <label for="color" class="fw-bold">Select Color:</label>
                <select name="color" id="color" class="form-control w-50 mb-2">
                    @foreach($product->variants as $variant)
                    <option value="{{ $variant->color }}">{{ ucfirst($variant->color) }}</option>
                    @endforeach
                </select>
                @endif
                <button type="submit" class="btn btn-success w-25">Add to Cart</button>
                <button type="submit" class="btn btn-warning w-25" formaction="{{ route('buy.now') }}">Buy Now</button>
            </form>
            <a href="{{ url('/') }}" class="btn btn-secondary mt-3">Back to Shop</a>
        </div>

        <!-- Delivery Options & Return/Warranty -->
        <div class="col-md-3 text-capitalize" style="border-left: 1px solid grey;">
            <p class="h5 mt-5 fw-bold">Delivery options:</p>

            @forelse($product->deliveryOptions as $delivery)
            <div class="d-flex justify-content-between align-items-center mt-3" style="border-bottom: 1px solid black;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-truck" style="font-size: 32px;margin-right:20px;"></i>
                    <p class="m-0">{{ $delivery->option_name }}</p>
                </div>
                <div>
                    <p class="m-0">Rs {{ number_format($delivery->price) }}</p>
                </div>
            </div>
            @empty
            <p>No delivery options available.</p>
            @endforelse

            <!-- Return & Warranty -->
            <p class="h5 mt-5 fw-bold">Return & Warranty:</p>

            <div class="d-flex justify-content-between align-items-center mt-3" style="border-bottom: 1px solid black;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-arrow-return-left" style="font-size: 32px;margin-right:20px;"></i>
                    <p class="m-0">{{ $product->returnWarranty->return_policy ?? 'No Return Policy' }}</p>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3" style="border-bottom: 1px solid black;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-shield-check" style="font-size: 32px;margin-right:20px;"></i>
                    <p class="m-0">{{ $product->returnWarranty->warranty ?? 'No Warranty Available' }}</p>
                </div>
            </div>

            <p class="mt-2 fw-bold">Follow us for exclusive discounts!</p>
        </div>
    </div>
</div>

<!-- Modal for showing success message -->
<div id="cartModal" class="modal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Product Added to Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Product has been added to your cart successfully!
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // $("#addToCartForm").on("submit", function(e) {
    //     e.preventDefault();
    //     var formData = $(this).serialize();
    //     // let id = $("input[name='id']").val();
    //     var id = "{{ $product->id }}";
    //     // let id = $("input[name='product_id']").val();
    //     alert(id);
    //     $.ajax({
    //         url: `products.detail.${id}.cart.add`,
    //         method: "POST",
    //         data: formData,
    //         headers: {
    //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // Ensure CSRF token is sent
    //         },
    //         success: function(response) {
    //             if (response.success) {
    //                 // Show success modal
    //                 $('#cartModal').modal('show');
    //                 // Update the cart count
    //                 $('.cart-count').text(response.cartCount);
    //             }
    //         },
    //         error: function(xhr) {
    //             alert('Error: Could not add to cart');
    //         }
    //     });
    // });

    $("#addToCartForm").on("submit", function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        let id = $("input[name='product_id']").val(); // FIXED ID
        $.ajax({
            url: "/products/detail/cart/add", // FIXED ROUTE
            method: "POST",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(response) {
                if (response.success) {
                    $('#cartModal').modal('show');
                    $('.cart-count').text(response.cartCount);
                }
            },
            error: function(xhr) {
                alert('Error: Could not add to cart');
            }
        });
    });
</script>
@endsection