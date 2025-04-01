<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <!-- Include Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
    <!-- Include Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .products .col-lg-2 img {
            width: 100%;
            height: 300px;
            border-radius: 30px;
        }

        .headerIcons {
            font-size: 25px;
        }

        .headerIcons {
            font-size: 24px;
            cursor: pointer;
            transition: color 0.3s ease-in-out;
        }

        .headerIcons:hover {
            color: #ff6600;
        }

        /* Product Image Styling */
        .product-img {
            width: 100%;
            height: 300px;
            border-radius: 8px;
            transition: transform 0.3s ease-in-out;
        }

        .category-img {
            width: 100%;
            height: 220px;
            border-radius: 20px;
            transition: transform 0.3s ease-in-out;
        }

        .product-img:hover {
            transform: scale(1.05);
        }

        /* Discount Styling */
        .discount-badge {
            background-color: #ff6600;
            color: white;
            font-size: 14px;
            padding: 3px 6px;
            border-radius: 4px;
        }

        /* Product Card */
        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: box-shadow 0.3s ease-in-out;
        }

        .product-card:hover {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .social-icon {
            font-size: 1.5rem;
            /* Bigger icons */
            color: #333;
            /* Default icon color */
            transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .social-icon:hover {
            color: #007bff;
            /* Change to primary blue on hover */
            transform: scale(1.2);
            /* Slight zoom effect */
        }
    </style>
</head>

<body>
    <div id="app" class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto"></ul>
                    <input type="search" id="searchProducts" class="form-control form-control-lg" placeholder="Search Products">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <div class="d-flex">
                            <a href="{{ url('/') }}" class="text-decoration-none text-dark">
                                <i class="bi bi-house-door headerIcons mx-2"></i>
                            </a>
                            <a href="{{ url('/cart') }}" class="text-decoration-none text-dark">
                                <i class="bi bi-cart headerIcons"></i>
                            </a>
                        </div>

                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4 flex-grow-1">
            @yield('content')
        </main>


        <!-- Footer -->
        <footer class="bg-light">
            <div class="container mt-5">
                <div class="row">
                    <!-- Follow Us Section -->
                    <div class="col-lg-4 col-md-4 col-12 d-flex align-items-center justify-content-around">
                        <div>
                            <h4 class="m-0 fw-bold">Follow Us: </h4>
                        </div>
                        <div class="d-flex gap-3">
                            <a href="https://facebook.com" target="_blank" class="social-icon"><i class="bi bi-facebook"></i></a>
                            <a href="https://instagram.com" target="_blank" class="social-icon"><i class="bi bi-instagram"></i></a>
                            <a href="https://twitter.com" target="_blank" class="social-icon"><i class="bi bi-twitter-x"></i></a>
                            <a href="https://tiktok.com" target="_blank" class="social-icon"><i class="bi bi-tiktok"></i></a>
                            <a href="https://youtube.com" target="_blank" class="social-icon"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                    <!-- Empty Column (For Alignment) -->
                    <div class="col-lg-4 col-md-4 col-12"></div>
                    <!-- Copyright Section -->
                    <div class="col-lg-4 col-md-4 col-12 text-lg-end text-md-end text-center mt-3 mt-md-0">
                        <p class="m-0 text-muted">
                            Copyright &copy; {{ config('app.name', 'Laravel') }} {{ date('Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>