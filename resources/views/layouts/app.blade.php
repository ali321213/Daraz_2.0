<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{asset('favicon.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Roboto Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .ubuntu-light {
            font-family: "Ubuntu", sans-serif;
            font-weight: 300;
            font-style: normal;
        }

        .ubuntu-regular {
            font-family: "Ubuntu", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .ubuntu-medium {
            font-family: "Ubuntu", sans-serif;
            font-weight: 500;
            font-style: normal;
        }

        .ubuntu-bold {
            font-family: "Ubuntu", sans-serif;
            font-weight: 700;
            font-style: normal;
        }

        .ubuntu-light-italic {
            font-family: "Ubuntu", sans-serif;
            font-weight: 300;
            font-style: italic;
        }

        .ubuntu-regular-italic {
            font-family: "Ubuntu", sans-serif;
            font-weight: 400;
            font-style: italic;
        }

        .ubuntu-medium-italic {
            font-family: "Ubuntu", sans-serif;
            font-weight: 500;
            font-style: italic;
        }

        .ubuntu-bold-italic {
            font-family: "Ubuntu", sans-serif;
            font-weight: 700;
            font-style: italic;
        }

        body {
            /* background-color:rgb(43, 41, 41);
            color: white; */
            font-family: "Ubuntu", sans-serif;
            font-weight: 700;
            font-style: italic;
        }

        .bannerImg {
            width: 100%;
            height: 600px;
            border-radius: 4px;
        }

        .products .col-lg-2 img {
            width: 100%;
            height: 300px;
            border-radius: 30px;
        }

        .headerIcons {
            font-size: 35px;
            cursor: pointer;
            /* color: white; */
            transition: color 0.3s ease-in-out;
        }

        .card-img-top {
            border-radius: 20px;
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
            text-transform: capitalize;
            border-radius: 10px;
            padding: 15px;
            transition: box-shadow 0.3s ease-in-out;
        }

        .img-fluid {
            width: 100%;
            height: 500px;
            border-radius: 20px;
        }

        .product-card:hover {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .CategoryCard:hover {
            box-shadow: 0px 14px 20px rgba(0, 0, 0, 0.2);
            border-radius: 30px;
            transition: 1s;
            padding: 5px;
        }

        .social-icon {
            font-size: 1.5rem;
            transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .social-icon i {
            color: black;
        }

        .social-icon i:hover {
            color: #ff6600;
            transform: scale(1.5);
        }

        .carousel-control-prev-icon {
            color: black;
        }

        .carousel-control-next-icon {
            color: black;
        }
    </style>
</head>

<body>
    <div id="app" class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="font-size: 30px; font-weight: 800;">
                    <img src="{{ asset('favicon.png') }}" alt="Logo" style="width: 50px; height: 50px; border-radius: 10%;">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto "></ul>
                    <input type="search" id="searchProducts" class="form-control form-control-lg" placeholder="Search Products Here" aria-label="Search" style="width: 500px;">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <div class="d-flex">
                            @php
                            $cartCount = Auth::check() ? Auth::user()->carts->sum('quantity') : 0;
                            @endphp
                            @if(Auth::check())
                            <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark d-flex">
                                <i class="bi bi-cart headerIcons"></i>
                                <span class="cart-count text-center fw-bold" style="background-color: #ff6600; color: white; border-radius: 50%; width: 30px; height: 30px; line-height: 2;">
                                    {{ $cartCount }}
                                </span>
                            </a>
                            @endif
                        </div>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('/products') }}">{{ __('Products') }}</a>
                        </li> -->
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item mt-2">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item mt-2">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle mt-2" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
        <main>
            @yield('content')
        </main>
        <!-- Footer -->
        <footer style="position: relative;right: 0;bottom: 0;left: 0;z-index: 1030;">
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
                        <p class="m-0">
                            Copyright &copy; {{ config('app.name', 'Laravel') }} {{ date('Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script>
        $(document).ready(function() {
            updateCartTotal();

            function updateCartTotal() {
                $.get("{{ route('cart.total') }}", function(response) {
                    $("#subtotal").text(response.subtotal);
                    $("#tax").text(response.tax);
                    $("#shipping").text(response.shipping);
                    $("#total").text(response.total);
                });
            }
            updateCartTotal(); // Call when page loads
        });

        $(document).on("change", ".update-cart", function() {
            let cartId = $(this).data("id");
            let quantity = $(this).val();

            $.ajax({
                url: "{{ route('cart.update') }}",
                method: "POST",
                data: {
                    id: cartId,
                    quantity: quantity,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $(".cart-count").text(response.cartCount);
                    updateCartTotal();
                }
            });
        });


        $("#searchProducts").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('search.suggestions') }}",
                    method: "GET",
                    data: {
                        query: request.term
                    },
                    dataType: "json", // ✅ Ensures JSON response is expected
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.name,
                                value: item.name,
                                id: item.id
                            };
                        }));
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error:", error);
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                window.location.href = "/products/" + ui.item.id;
            }
        });
    </script>
</body>

</html>