@extends('layouts.app')
@section('content')
@section('title', 'Login Page')
<div class="conatiner">
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <h2 class="my-5">Login Page</h2>

            @if(session('message'))
            <p style="color: green;">{{ session('message') }}</p>
            @endif

            @if($errors->any())
            <p style="color: red;">{{ $errors->first() }}</p>
            @endif
            <form action="{{ route('login_submit') }}" method="POST">
                @csrf
                <div class="form-group form-group-lg">
                    <label>Email address</label>
                    <input type="email" name="email" class="form-control form-control-lg" aria-describedby="emailHelp" required>
                </div>
                <div class="form-group form-group-lg">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>
@endsection