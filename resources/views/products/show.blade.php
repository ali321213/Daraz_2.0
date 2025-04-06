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
        <div class="col-md-6">
            <!-- Product Image -->
            <div id="productCarousel{{ $product->id }}" class="carousel slide ProductCarousel" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($product->images as $key => $image)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100 img-fluid" alt="{{ $product->name }}">
                    </div>
                    @endforeach
                </div>
                <!-- Carousel Controls -->
                @if($product->images->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel{{ $product->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel{{ $product->id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-4 text-capitalize">
            <div class="float-end">
                <i class="bi bi-share" style="font-size: 32px;margin-right:20px;"></i>
                <i class="bi bi-heart wishlist" style="font-size: 32px;"></i>
            </div>
            <h1 class="fw-bold">{{ $product->name }}</h1>
            <p class="text-muted">Category: {{ $product->category->name ?? 'Uncategorized' }}</p>
            <p class="text-muted">Brand: {{ $product->brand->name ?? 'Uncategorized' }}</p>
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
                <button type="submit" name="action" value="add_to_cart" class="btn btn-success w-25">Add to Cart</button>
                <button type="submit" name="action" value="buy_now" class="btn btn-warning w-25">Buy Now</button>
            </form>
            <a href="{{ url('/') }}" class="btn btn-secondary mt-3">Back to Shop</a>
        </div>

        <!-- Delivery Options & Return/Warranty -->
        <div class="col-md-2 text-capitalize" style="border-left: 1px solid grey;">
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

    <div class="row">
        <div class="col-lg-12">
            <div class="mt-5">
                <h4 class="fw-bold">Customer Reviews</h4>
                <div id="reviewContainer">
                    @foreach($reviews as $review)
                    <div class="border p-3 mb-3 rounded review-item" data-id="{{ $review->id }}">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $review->user->name }}</strong>
                            <span>{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : '' }}"></i>
                                @endfor
                        </div>
                        <p class="review-text">{{ $review->review }}</p>
                        @if($review->image)
                        <img src="{{ asset('storage/' . $review->image) }}" class="img-fluid mt-2" style="max-width:150px;">
                        @endif
                        <div class="d-flex align-items-center mt-2">
                            <button class="btn btn-outline-primary btn-sm me-2 like-btn" data-id="{{ $review->id }}">
                                👍 <span class="like-count">{{ $review->likes_count }}</span>
                            </button>
                            @if(auth()->id() == $review->user_id)
                            <button class="btn btn-outline-secondary btn-sm me-2 edit-btn" data-id="{{ $review->id }}">✏️ Edit</button>
                            <select class="form-control mb-2 edit-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $i == $review->rating ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                            </select>

                            <button class="btn btn-outline-danger btn-sm delete-btn" data-id="{{ $review->id }}">🗑️ Delete</button>
                            @endif
                        </div>
                        {{-- Replies --}}
                        @foreach($review->replies as $reply)
                        <div class="ms-4 mt-3 p-2 border-start border-2">
                            <strong>{{ $reply->user->name }}</strong>
                            <p>{{ $reply->review }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                    <div class="text-center">
                        {{ $reviews->links() }}
                    </div>
                </div>
                <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#reviewModal">Write a Review</button>
            </div>
        </div>
    </div>


    {{-- Review Modal --}}
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="reviewForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Write a Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-2">
                            <label class="form-label">Rating (1 to 5):</label>
                            <input type="number" name="rating" class="form-control" min="1" max="5" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Review:</label>
                            <textarea name="review" class="form-control" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Image (optional):</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </div>
                </div>
            </form>
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
    //     let id = $("input[name='product_id']").val();
    //     $.ajax({
    //         url: "/products/detail/cart/add",
    //         method: "POST",
    //         data: formData,
    //         headers: {
    //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    //         },
    //         success: function(response) {
    //             if (response.success) {
    //                 $('#cartModal').modal('show');
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
        let action = $(document.activeElement).val(); // 'add_to_cart' or 'buy_now'
        let url = action === 'buy_now' ? '/products/detail/buy' : '/products/detail/cart/add';

        $.ajax({
            url: url,
            method: "POST",
            data: $(this).serialize(),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(response) {
                if (action === 'add_to_cart') {
                    $('#cartModal').modal('show');
                    $('.cart-count').text(response.cartCount);
                } else {
                    window.location.href = response.redirect_url;
                }
            },
            error: function(xhr) {
                alert('Error: Could not process request');
            }
        });
    });


    // Submit Review
    $("#reviewForm").on("submit", function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "/reviews/store",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                alert(res.message);
                // location.reload();
            }
        });
    });

    // Update Review
    function updateReview(id) {
        let data = {
            review: $("#editReviewText" + id).val(),
            rating: $("#editRating" + id).val(),
            _token: "{{ csrf_token() }}"
        };

        $.post(`/reviews/${id}/update`, data, function(res) {
            alert(res.message);
            location.reload();
        });
    }

    // Upvote / Downvote
    function vote(reviewId, type) {
        $.post(`/reviews/vote`, {
            id: reviewId,
            type: type,
            _token: "{{ csrf_token() }}"
        }, function(res) {
            $("#upvotes-" + reviewId).text(res.upvotes);
            $("#downvotes-" + reviewId).text(res.downvotes);
        });
    }


    function loadReviews(productId) {
        $.get(`/reviews/${productId}`, function(html) {
            $("#reviewContainer").html(html);
        });
    }

    $(document).on('click', '.like-btn', function() {
        let id = $(this).data('id');
        $.post("{{ route('reviews.like') }}", {
            id,
            _token: '{{ csrf_token() }}'
        }, function(res) {
            $(`.review-item[data-id="${id}"] .like-count`).text(res.likes);
            if (res.status === 'already_liked') {
                alert('You already liked this review.');
            } else {
                $(`.review-item[data-id="${id}"] .like-count`).text(res.likes);
            }
        });
    });

    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        let reviewItem = $(`.review-item[data-id="${id}"]`);
        let reviewText = reviewItem.find('.review-text').text();
        let rating = reviewItem.find('.edit-rating').val();

        // Replace text with a textarea
        reviewItem.find('.review-text').replaceWith(`
        <textarea id="editReviewText${id}" class="form-control mb-2">${reviewText}</textarea>
    `);
        // Change edit button to a save button
        $(this).replaceWith(`
        <button class="btn btn-success btn-sm save-btn" data-id="${id}">💾 Save</button>
    `);
    });

    $(document).on('click', '.save-btn', function() {
        let id = $(this).data('id');
        updateReview(id);
    });


    // Update Review
    $(document).on('click', '.update-btn', function() {
        let id = $(this).data('id');
        let newRating = $(`.review-item[data-id="${id}"] .edit-rating`).val();
        let newText = $(`.review-item[data-id="${id}"] .update-review`).val();
        $.ajax({
            url: `/reviews/${id}/update`,
            type: "POST",
            data: {
                review: newText,
                rating: 5, // default rating on edit
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                alert(res.message);
                location.reload();
            }
        });
    });

    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        if (confirm('Are you sure?')) {
            $.ajax({
                url: `/reviews/${id}`,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    alert(res.message);
                    location.reload();
                }
            });
        }
    });
</script>
@endsection