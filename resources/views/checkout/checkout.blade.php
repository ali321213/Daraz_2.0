@extends('layouts.app')
@section('content')
@section('title', 'Checkout')
<div class="container mt-5">
    <h1 class="fw-bold mb-4">Checkout</h1>
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Address</label>
            <textarea name="address" class="form-control" required></textarea>
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