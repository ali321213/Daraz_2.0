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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// ADMIN PRODUCTS ROUTES
Route::prefix('admin/products')->name('admin.products.')->group(function () {
    Route::get('/index', [ProductController::class, 'products'])->name('index'); // List all products
    Route::get('/create', [ProductController::class, 'create'])->name('create'); // Show product create form
    Route::post('/store', [ProductController::class, 'store'])->name('store'); // Store product
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit'); // Edit product
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('update'); // Update product
    Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy'); // Delete product
    Route::get('/search', [ProductController::class, 'search'])->name('search'); // Search product
    Route::get('/{id}', [ProductController::class, 'show'])->name('show'); // Show single product
});

// ADMIN BRANDS ROUTES
Route::prefix('admin/brands')->name('admin.brands.')->group(function () {
    Route::get('/', [BrandController::class, 'index'])->name('index');
    Route::get('/show', [BrandController::class, 'show'])->name('show');
    Route::post('/create', [BrandController::class, 'create'])->name('create');
    Route::post('/store', [BrandController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
    Route::put('/{brand}', [BrandController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [BrandController::class, 'destroy'])->name('destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('orders', OrderController::class);
});

Route::middleware(['admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
});

Route::middleware(['customer'])->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// =============================================================================================================================
// Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin/banners')->name('admin.banners.')->group(function () {
    Route::get('/', [BannerController::class, 'index'])->name('index');
    Route::get('/create', [BannerController::class, 'create'])->name('create');
    Route::post('/store', [BannerController::class, 'store'])->name('store');
});



/*
|--------------------------------------------------------------------------
| Public Routes (Accessible to Everyone)
|--------------------------------------------------------------------------
*/
// Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Login, Register, Logout)
|--------------------------------------------------------------------------
*/
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
// Route::post('/login', [AuthController::class, 'login']);

// Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
// Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| User Dashboard & Profile (Requires Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | Cart Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product_id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{cart_id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{cart_id}', [CartController::class, 'remove'])->name('cart.remove');

    /*
    |--------------------------------------------------------------------------
    | Checkout & Orders
    |--------------------------------------------------------------------------
    */
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order_id}', [OrderController::class, 'show'])->name('orders.show');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Requires Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Manage Products
    |--------------------------------------------------------------------------
    */
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('admin.products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::post('/products/delete/{id}', [ProductController::class, 'destroy'])->name('admin.products.delete');

    /*
    |--------------------------------------------------------------------------
    | Manage Categories
    |--------------------------------------------------------------------------
    */
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::post('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.delete');

    /*
    |--------------------------------------------------------------------------
    | Manage Brands
    |--------------------------------------------------------------------------
    */
    // Route::get('/brands', [BrandController::class, 'index'])->name('admin.brands');
    // Route::post('/brands/store', [BrandController::class, 'store'])->name('admin.brands.store');
    // Route::post('/brands/update/{id}', [BrandController::class, 'update'])->name('admin.brands.update');
    // Route::post('/brands/delete/{id}', [BrandController::class, 'destroy'])->name('admin.brands.delete');

    /*
    |--------------------------------------------------------------------------
    | Manage Orders
    |--------------------------------------------------------------------------
    */
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders');
    Route::get('/orders/{order_id}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
    Route::post('/orders/update-status/{order_id}', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    /*
    |--------------------------------------------------------------------------
    | Manage Users
    |--------------------------------------------------------------------------
    */
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/update/{user_id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/users/delete/{user_id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});
