@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background-color: #eff0f5;border-radius: 20px;">
    <div class="row">
        <div class="col-lg-12 mt-5">
            <h1>Create your Daraz_2.0 Account</h1>
            <p class="text-muted">Create an account to enjoy a faster checkout experience, track your orders, and receive exclusive offers.</p>
            <p class="text-muted">Already have an account? <a href="{{ route('login') }}">Login</a></p>
            <p class="text-muted">By signing up, you agree to our <a href="{{ route('login') }}">Terms of Service</a> and <a href="{{ route('login') }}">Privacy Policy</a>.</p>
            <p class="text-muted">We will send you a verification code via SMS to verify your phone number.</p>
            <p class="text-muted">Please enter your phone number to receive the verification code.</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-2 col-md-2"></div>
        <div class="col-lg-8 col-md-12 col-sm-12 col-12">
            <div class="py-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth') }}</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="dob" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" required>
                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('SMS Verification Code') }}</label>
                            <div class="col-md-6">
                                <input type="text" maxlength="6" class="form-control" name="sms_code" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div> -->

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-info fw-bold w-100 text-white" style="font-size: 17px;">Sign Up</button>
                            </div>
                            <p>Or, Sign up with</p>
                            <div class="d-flex mb-4" style="gap: 1%;">
                                <a href="{{ route('social.login', 'google') }}" class="btn fw-bold" style="border: 1px solid black;">
                                    <i class="bi bi-facebook"></i> {{ __('Register with Facebook') }}
                                </a>
                                <a href="{{ route('social.login', 'google') }}" class="btn fw-bold" style="border: 1px solid black;">
                                    <i class="bi bi-google"></i> {{ __('Register with Google') }}
                                </a>
                                <!-- <button type="button">
                                    <i class="bi bi-facebook"></i> {{ __('Register with Facebook') }}
                                </button>
                                <button type="button">
                                    <i class="bi bi-google"></i> {{ __('Register with Google') }}
                                </button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2"></div>
    </div>
</div>
@endsection