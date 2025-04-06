<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

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
    return view('home');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');


// Route::get('/cart', function(){
//     return view('cart');
// });

// Product
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Product Details
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

//RL Note to SQ: I put the code from ur middleware outside first ahh, if not my cart can't be shown
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{productId}', [CartController::class, 'removeProduct'])->name('cart.remove');
Route::post('cart/update/{productId}', [CartController::class, 'updateCartQuantity']);

// This does not work derrr, but if delete then cannot show the product details
// Route::middleware(['customer'])->group(function () {
//     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
//     Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
//     Route::delete('/cart/remove/{product}', [CartController::class, 'removeProduct'])->name('cart.remove');
// });
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/orders', function () {
        return view('profile.order');
    })->name('profile.order');
});
