<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cart', function(){
    return view('cart');
});

// Product
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Product Details
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


// This does not work derrr, but if delete then cannot show the product details
Route::middleware(['customer'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{product}', [CartController::class, 'removeProduct'])->name('cart.remove');
});