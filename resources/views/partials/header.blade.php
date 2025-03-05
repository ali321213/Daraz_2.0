<header>
    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('products.index') }}">Shop</a>
        <a href="{{ route('cart.index') }}">Cart</a>
        <a href="{{ route('orders.index') }}">Orders</a>
        @auth
            <a href="{{ route('profile') }}">{{ auth()->user()->name }}</a>
            <a href="{{ route('logout') }}">Logout</a>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </nav>
</header>
