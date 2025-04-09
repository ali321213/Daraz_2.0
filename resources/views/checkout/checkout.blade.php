@extends('layouts.app')
@section('title', 'Checkout')
@section('content')

<div class="container mt-5">
    <h1 class="fw-bold mb-4">Checkout</h1>
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Address Line</label>
            <input type="text" name="address_line" class="form-control" required>
        </div>

        {{-- Replace the country, state, city fields like this --}}

        <div class="mb-3">
            <label class="form-label fw-bold">Country</label>
            <input type="text" name="country" class="form-control" value="{{ $country->name }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">State</label>
            <select name="state" class="form-control" required>
                <option value="">Select State</option>
                @foreach($states as $state)
                <option value="{{ $state->name }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">City</label>
            <select name="city" class="form-control" required>
                <option value="">Select City</option>
                @foreach($cities as $city)
                <option value="{{ $city->name }}">{{ $city->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Postal Code</label>
            <input type="text" name="postal_code" class="form-control" required>
        </div>
        <div class="row mb-3">
            <label class="col-md-4 col-form-label text-md-end">{{ __('Payment Method') }}</label>
            <div class="col-md-6">
                <select name="payment_method" class="form-control" required>
                    <option value="cod">Cash on Delivery</option>
                    <option value="card">Credit/Debit Card</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Payment Method</label>
            <select name="payment_method" class="form-control" required>
                <option value="cod">Cash on Delivery</option>
                <option value="card">Credit/Debit Card</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Place Order</button>
    </form>
</div>
@endsection