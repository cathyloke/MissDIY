<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;

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

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
});

Route::put('/sale/{sale}/complete', [SalesController::class, 'markAsCompleted'])->name('sale.complete');

// Checkout to payment
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
// Route::get('/payment', [PaymentController::class, 'index'])->middleware('auth')->name('payment.index');
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');


Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}/deactivate', [CategoryController::class, 'deactivate'])->name('categories.deactivate');
Route::patch('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');


