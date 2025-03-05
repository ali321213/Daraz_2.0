<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - My eCommerce</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

    @include('partials.header')

    <div class="container">
        @yield('content')
    </div>

    @include('partials.footer')

    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
