<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    AdminController,
    BannerController,
    BrandController,
    CartController,
    CategoryController,
    CheckoutController,
    HomeController,
    OrderController,
    PaymentController,
    ProductController,
    ProfileController,
    ReviewController,
    UnitController,
    UserController
};
use App\Http\Middleware\GuestMiddleware;

// ================== Public Routes ==================

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'signup'])->name('register');
Route::post('/login_submit', [AuthController::class, 'login_submit'])->name('login_submit');
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::middleware('guest')->group(function () {});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/search-suggestions', [ProductController::class, 'search'])->name('search.suggestions');

// Product Browsing
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/detail/{id}', [ProductController::class, 'ProductDetails'])->name('detail');
    Route::get('/getProducts', [ProductController::class, 'getProducts'])->name('getProducts');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
});

// ================== Authenticated User Routes ==================
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order_id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');

    // Cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/update', [CartController::class, 'updateCart'])->name('update');
        Route::post('/remove', [CartController::class, 'remove'])->name('remove');
        Route::post('/update/all', [CartController::class, 'updateAll'])->name('update.all');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/total', [CartController::class, 'calculateCartTotal'])->name('total');
    });

    // Optional: Product detail-level cart (if needed)
    Route::prefix('products/detail/cart')->name('products.detail.cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/update', [CartController::class, 'updateCart'])->name('update');
        Route::post('/remove', [CartController::class, 'removeFromCart'])->name('remove');
    });
});
// Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


// ================== Customer Only Routes ==================
Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
Route::post('/reviews/{id}/update', [ReviewController::class, 'update']);
Route::post('/reviews/like', [ReviewController::class, 'like'])->name('reviews.like');
Route::middleware(['auth', 'customer'])->group(function () {
    // Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/vote', [ReviewController::class, 'vote']);
    Route::get('/reviews/{product}', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/update', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
    Route::post('/reviews/{review}/delete', [ReviewController::class, 'delete'])->name('reviews.delete');
});

// ================== Admin Only Routes ==================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('dashboard');
    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/update/{user_id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/users/delete/{user_id}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Admin Product Management
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::post('/create', [ProductController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::get('/search', [ProductController::class, 'search'])->name('search');
        Route::get('/{id}', [ProductController::class, 'show'])->name('show');
    });

    // Admin Orders
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders');
    Route::get('/orders/{order_id}', [OrderController::class, 'adminShow'])->name('orders.show');
    Route::post('/orders/update-status/{order_id}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Brands
    Route::prefix('brands')->name('brands.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::post('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [BrandController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [BrandController::class, 'destroy'])->name('destroy');
        Route::get('/search', [ProductController::class, 'search'])->name('search');
        Route::get('/show', [BrandController::class, 'show'])->name('show');
    });

    // Categories
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/{categoryId}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/{categoryId}/update', [CategoryController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::get('/search', [CategoryController::class, 'search'])->name('search');
    });

    // Banners
    Route::prefix('banners')->name('banners.')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('index');
        Route::get('/create', [BannerController::class, 'create'])->name('create');
        Route::post('/store', [BannerController::class, 'store'])->name('store');
        Route::get('/{bannerId}/edit', [BannerController::class, 'edit'])->name('edit');
        Route::post('/{bannerId}/update', [BannerController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [BannerController::class, 'destroy'])->name('destroy');
        Route::post('/toggleStatus', [BannerController::class, 'toggleStatus'])->name('toggleStatus');
    });

    // Units
    Route::prefix('units')->name('units.')->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('index');
        Route::get('/create', [UnitController::class, 'create'])->name('create');
        Route::post('/', [UnitController::class, 'store'])->name('store');
        Route::get('edit/{id}', [UnitController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [UnitController::class, 'update'])->name('update');
        Route::delete('/{id}', [UnitController::class, 'destroy'])->name('destroy');
        Route::get('/search', [UnitController::class, 'search'])->name('search');
    });
});

// ================== Payment Routes ==================
Route::get('/payment/initiate/{gateway}', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
Route::post('/payment/callback/{gateway}', [PaymentController::class, 'handleCallback'])->name('payment.callback');
Route::get('buy.now', [AuthController::class, 'buyNow'])->name('buy.now');
// Social login
// Social Login Routes
Route::get('login/{provider}', [AuthController::class, 'redirectToProvider'])->name('social.login');
Route::get('login/{provider}/callback', [AuthController::class, 'handleProviderCallback']);
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy.policy');

Route::get('/data-deletion', function () {
    return view('data-deletion');
})->name('data.deletion');