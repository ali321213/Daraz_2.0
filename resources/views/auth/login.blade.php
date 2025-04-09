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
                <div class="form-group form-group-lg mb-3">
                    <label>Email address</label>
                    <input type="email" name="email" class="form-control form-control-lg" aria-describedby="emailHelp" required>
                </div>
                <div class="form-group form-group-lg">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" required>
                    <a href="{{ route('social.login', 'google') }}" class="my-3 text-decoration-none text-muted">Forget Password?</a>
                </div>
                <button type="submit" class="btn btn-primary mt-3 w-100 fw-bold">Submit</button>
                
                <a href="{{ route('social.login', 'google') }}" class="btn btn-danger btn-block w-100 mt-3 fw-bold">Login with Google</a>
                <a href="{{ route('social.login', 'facebook') }}" class="btn btn-primary btn-block w-100 mt-1 fw-bold">Login with Facebook</a>
            </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>
@endsection