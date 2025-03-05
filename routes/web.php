<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'products'])->name('products');

// Route::get('/products', [ProductController::class, 'show']);
// Route::post('/add-products', [ProductController::class, 'store'])->name('product');
// Route::get('/get-products', [ProductController::class, 'getProducts']);  
// Route::get('/get-product/{id}', [ProductController::class, 'edit_product']);
// Route::post('/update-products/{id}', [ProductController::class, 'update']);
// Route::delete('/delete-product/{id}', [ProductController::class, 'destroy']);
// Route::get('/search-products', [ProductController::class, 'search']);
// Route::get('/home', [ProductController::class, 'products'])->name('home');

Route::prefix('products')->group(function () {
    Route::get('/show', [ProductController::class, 'show'])->name('show');
    Route::get('/detail', [ProductController::class, 'detail'])->name('detail');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('edit_product/{id}', [ProductController::class, 'edit_product'])->name('products.edit');
    Route::post('update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/{id}', [ProductController::class, 'ProductDetails'])->name('products.show');
});

Route::get('/products/index', [ProductController::class, 'products'])->name('products.index');



Route::middleware(['auth'])->group(function () {
    Route::resource('orders', OrderController::class);
});

Route::middleware(['admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('products', ProductController::class);
});

Route::middleware(['customer'])->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});