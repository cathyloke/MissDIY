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

//Non login user routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Auth::routes();

Route::middleware(['auth'])->group(function () {

    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Sales
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');

    Route::middleware(['admin'])->group(function () {
        // CUD products
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

        // CRUD Category
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}/deactivate', [CategoryController::class, 'deactivate'])->name('categories.deactivate');
        Route::patch('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');

        // Sales
        Route::put('/sale/{sale}/delivering', [SalesController::class, 'markAsDelivering'])->name('sale.delivering');
    });

    Route::middleware(['customer'])->group(function () {
        // Cart
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
        Route::delete('/cart/remove/{productId}', [CartController::class, 'removeProduct'])->name('cart.remove');
        Route::post('cart/update/{productId}', [CartController::class, 'updateCartQuantity']);

        // Checkout to payment
        Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
        Route::post('/payment', [PaymentController::class, 'process'])->name('payment.process');
        Route::post('/payment/apply-discount', [PaymentController::class, 'applyDiscount'])->name('payment.apply_discount');

        // Sales
        Route::put('/sale/{sale}/complete', [SalesController::class, 'markAsCompleted'])->name('sale.complete');
    });
});

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
