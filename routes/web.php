<?php

use App\Http\Controllers\ProductController;
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
    Route::get('/show', [ProductController::class, 'show'])->name('show'); // Display all products
    Route::get('/detail', [ProductController::class, 'detail'])->name('detail'); // Display all products
    Route::post('/store', [ProductController::class, 'store'])->name('products.store'); // Add a new product
    Route::get('edit_product/{id}', [ProductController::class, 'edit_product'])->name('products.edit'); // Get a specific product for editing
    Route::post('update/{id}', [ProductController::class, 'update'])->name('products.update'); // Update a specific product
    Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy'); // Delete a product
    Route::get('/search', [ProductController::class, 'search'])->name('products.search'); // Search products
});
Route::get('/products/index', [ProductController::class, 'products'])->name('products.index');