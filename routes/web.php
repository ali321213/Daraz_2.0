<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/product', [ProductController::class, 'index'])->name('product');


Route::get('/products', [ProductController::class, 'show']);
Route::post('/add-products', [ProductController::class, 'store']);
Route::get('/get-products', [ProductController::class, 'getProducts']);
Route::post('/products/update/{id}', [ProductController::class, 'update']);

Route::delete('/delete-product/{id}', [ProductController::class, 'destroy']);