<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

// Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');

// ADMIN PRODUCTS ROUTES

Route::middleware(['auth'])->group(function () {
    Route::resource('orders', OrderController::class);
});

Route::middleware(['customer'])->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
// 🔹 Guest Middleware - Only for Unauthenticated Users
// Route::middleware(['guest'])->group(function () {
//     Route::get('/login', [UserController::class, 'showLogin'])->name('login');
//     Route::get('/register', [UserController::class, 'showRegister'])->name('register');
// });

// // 🔹 Auth Middleware - Only for Logged-in Users
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
//     Route::get('/profile', [UserController::class, 'profile'])->name('profile');
//     Route::post('/logout', [UserController::class, 'logout'])->name('logout');
// });


// Route::get('/', [HomeController::class, 'index'])->name('home');
// Public Routes (Accessible to Everyone)
// Route::get('/', [ProductController::class, 'index'])->name('home');
// Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Authentication Routes (Login, Register, Logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login_submit', [AuthController::class, 'login_submit'])->name('login_submit')->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
// User Dashboard & Profile (Requires Authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    // Cart Routes
    // Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    // Route::post('/cart/add/{product_id}', [CartController::class, 'add'])->name('cart.add');
    // Route::post('/cart/update/{cart_id}', [CartController::class, 'update'])->name('cart.update');
    // Route::post('/cart/remove/{cart_id}', [CartController::class, 'remove'])->name('cart.remove');
    // Checkout & Orders
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order_id}', [OrderController::class, 'show'])->name('orders.show');
});

// Admin Routes (Requires Admin Middleware)
Route::get('admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    //  Manage Orders
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders');
    Route::get('/orders/{order_id}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
    Route::post('/orders/update-status/{order_id}', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    //  Manage Users
    Route::get('buy.now', [AuthController::class, 'buyNow'])->name('buy.now');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/update/{user_id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/users/delete/{user_id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/detail/{id}', [ProductController::class, 'ProductDetails'])->name('detail');
    Route::get('/getProducts', [ProductController::class, 'getProducts'])->name('getProducts');
    Route::post('/create', [ProductController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
});

Route::prefix('products/detail/cart')->name('products.detail.cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add'); // Matches AJAX request
    Route::post('/update', [CartController::class, 'updateCart'])->name('update');
    Route::post('/remove', [CartController::class, 'removeFromCart'])->name('remove');
});

// Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index'); // Show cart page
    Route::post('/add', [CartController::class, 'add'])->name('add'); // Add item to cart
    Route::post('/update', [CartController::class, 'update'])->name('update'); // Update item quantity
    Route::post('/remove', [CartController::class, 'remove'])->name('remove'); // Remove an item from cart
    Route::post('/clear', [CartController::class, 'clear'])->name('clear'); // Clear the entire cart
});

// ========================== ADMIN Routes ==========================
Route::prefix('admin/products')->name('admin.products.')->group(function () {
    Route::get('/index', [ProductController::class, 'index'])->name('index');
    Route::post('/create', [ProductController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
});

// BRANDS
Route::prefix('admin/brands')->name('admin.brands.')->group(function () {
    Route::get('/', [BrandController::class, 'index'])->name('index');
    Route::post('/create', [BrandController::class, 'create'])->name('create');
    Route::post('/store', [BrandController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [BrandController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [BrandController::class, 'destroy'])->name('destroy');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/show', [BrandController::class, 'show'])->name('show');
});


Route::prefix('admin/category')->name('admin.category.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/{categoryId}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::post('/{categoryId}/update', [CategoryController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    Route::get('/search', [CategoryController::class, 'search'])->name('search');
});


Route::prefix('admin/banners')->name('admin.banners.')->group(function () {
    Route::get('/', [BannerController::class, 'index'])->name('index');
    Route::get('/create', [BannerController::class, 'create'])->name('create');
    Route::post('/store', [BannerController::class, 'store'])->name('store');
    Route::get('/{bannerId}/edit', [BannerController::class, 'edit'])->name('edit');
    Route::post('/{bannerId}/update', [BannerController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [BannerController::class, 'destroy'])->name('destroy');
    Route::post('/toggleStatus', [BannerController::class, 'toggleStatus'])->name('toggleStatus');
});

Route::prefix('admin/units')->name('admin.units.')->group(function () {
    Route::get('/', [UnitController::class, 'index'])->name('index');
    Route::get('/create', [UnitController::class, 'create'])->name('create');
    Route::post('/', [UnitController::class, 'store'])->name('store');
    Route::get('edit/{id}', [UnitController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [UnitController::class, 'update'])->name('update');
    Route::delete('/{id}', [UnitController::class, 'destroy'])->name('destroy');
    Route::get('/search', [UnitController::class, 'search'])->name('search');
});
