<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/product', [ProductController::class, 'index'])->name('product');


Route::get('/products', [ProductController::class, 'show']);
Route::post('/add-products', [ProductController::class, 'store']);
// Route::get('/get-products', [ProductController::class, 'getProducts']);  
Route::get('/get-product/{id}', [ProductController::class, 'edit_product']);
Route::post('/update-products/{id}', [ProductController::class, 'update']);
Route::delete('/delete-product/{id}', [ProductController::class, 'destroy']);
Route::get('/search-products', [ProductController::class, 'search']);