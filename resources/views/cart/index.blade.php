@extends('layouts.app')
@section('title', 'Cart - Daraz 2.0')
@section('content')

@if($cart->count())
<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12 mt-5">
            <!-- <div id="cart-wrapper"> -->
            <form id="cartForm">
                @csrf
                <table class="table table-bordered text-center">
                    <thead class="bg-light">
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $item)
                        @php $lineTotal = $item->product->price * $item->quantity; @endphp
                        <tr>
                            <td><input type="checkbox" class="item-checkbox" data-id="{{ $item->id }}"></td>
                            <td>{{ $item->product->name }}</td>
                            <td>
                                <img src="{{ asset('storage/' . ($item->product->images->first()->image_path ?? 'assets/images/placeholder.jpg')) }}" width="70">
                            </td>
                            <td>Rs. {{ number_format($item->product->price) }}</td>
                            <td>
                                <input type="number" name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}" min="1"
                                    class="form-control quantity-input" data-id="{{ $item->id }}" data-price="{{ $item->product->price }}">
                            </td>
                            <td class="line-total" id="line-total-{{ $item->id }}">
                                Rs. {{ number_format($lineTotal) }}
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-btn" data-id="{{ $item->id }}">Remove</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="mt-3">
                                <button type="button" id="updateSelectedBtn" class="btn btn-success">Update Selected</button>
                                <button type="button" id="clearCartBtn" class="btn btn-danger">Clear Cart</button>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div style="float: right;">
                                <p class="h4" style="border-bottom: 1px solid black;">Subtotal: Rs. <span id="subtotal">0</span></p>
                                <p class="h4" style="border-bottom: 1px solid black;">Shipping Fee: Rs. <span id="shipping">0</span></p>
                                <p class="h4" style="border-bottom: 1px solid black;">Total: Rs. <span id="total">0</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('home') }}" class="btn btn-secondary">Continue Shopping</a>
                    <a href="{{ route('checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
                </div>


            </form>
            <!-- </div> -->
            @else
            <p class="alert alert-warning text-center">Your cart is empty.</p>
            <div class="text-center">
                <a href="{{ route('home') }}" class="btn btn-secondary">Shop Now</a>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    const updateTotals = () => {
        let subtotal = 0;
        $('.item-checkbox:checked').each(function() {
            const id = $(this).data('id');
            const qty = $(`.quantity-input[data-id=${id}]`).val();
            const price = $(`.quantity-input[data-id=${id}]`).data('price');
            subtotal += qty * price;
        });
        let shipping = subtotal > 0 ? 200 : 0;
        $('#subtotal').text(subtotal.toLocaleString());
        $('#shipping').text(shipping.toLocaleString());
        $('#total').text((subtotal + shipping).toLocaleString());
    };

    $(document).on('change', '.item-checkbox, .quantity-input', updateTotals);
    $('#selectAll').on('change', function() {
        $('.item-checkbox').prop('checked', $(this).prop('checked'));
        updateTotals();
    });

    $('#updateSelectedBtn').on('click', function() {
        let selectedData = {};
        $('.item-checkbox:checked').each(function() {
            let id = $(this).data('id');
            let qty = $(`.quantity-input[data-id=${id}]`).val();
            selectedData[id] = qty;
        });

        if (Object.keys(selectedData).length === 0) {
            alert('Please select items to update.');
            return;
        }

        $.ajax({
            url: "{{ route('cart.update.all') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                quantities: selectedData
            },
            success: function(res) {
                location.reload(); // or dynamically update cart without reload if needed
            }
        });
    });

    // Remove item
    $(document).on('click', '.remove-btn', function() {
        const id = $(this).data('id');
        $.post("{{ route('cart.remove') }}", {
            _token: "{{ csrf_token() }}",
            id: id
        }, function() {
            location.reload();
        });
    });

    // Clear Cart
    $('#clearCartBtn').on('click', function() {
        $.post("{{ route('cart.clear') }}", {
            _token: "{{ csrf_token() }}"
        }, function() {
            location.reload();
        });
    });

    // Initial total calc
    updateTotals();
</script>
@endsection