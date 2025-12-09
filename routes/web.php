<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReviewController;

// Route namings
Route::get('/', function () {
    return view('layouts.app');
})->name('home');
Route::get('/contact/{id}', function () {
    return view('layouts.app');
})->name('contact');
Route::get('/admin/{id}', function () {
    return view('layouts.app');
})->name('admin');
Route::get('/products', function () {
    return view('layouts.app');
})->name('products');

// API Routes (for CRUD operations)
Route::prefix('api')->group(function () {
    Route::post('/register', [AccountController::class, 'create']); 
    Route::post('/login', [AccountController::class, 'login']);
    Route::post('/contact', [ContactController::class, 'contact']);
    Route::get('/contacts', [ContactController::class, 'getAllContacts']);
    Route::post('/admin-login', [AdminController::class, 'adminLogin']);
    Route::post('/product', [ProductController::class, 'addProduct']);
    Route::get('/products', [ProductController::class, 'getAllProducts']);
    Route::get('/product/{id}', [ProductController::class, 'getProduct']);
    Route::post('/review', [ReviewController::class, 'addReview']);
    Route::get('/api/orders', [AdminController::class, 'getOrders']);
    Route::post('/update-product/{id}', [AdminController::class, 'updateProduct']);
    Route::delete('/delete-product/{id}', [AdminController::class, 'deleteProduct']);
    Route::post('/move-to-transaction', [OrderController::class, 'moveToTransaction']);
    Route::get('/api/carts', [OrderController::class, 'getAllCarts']);
    Route::get('/transactions/{id}', [TransactionController::class, 'getTransactions']);
    
    // Protected Pages
    // Route::get('/admin', function () { return view('layouts.app'); })->name('admin');

    // Protected API Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/account-info', [AccountController::class, 'getAccountInfo']);
        Route::patch('/account-info', [AccountController::class, 'updateAccountInfo']);
        Route::post('/logout', [AccountController::class, 'logout']);
        Route::patch('/accountInfo-update', [AccountController::class, 'updateAccountInfo']);
        Route::patch('/accountLogin-update', [AccountController::class, 'updateAccountLogin']);
        Route::delete('/accountDelete', [AccountController::class, 'deleteAccount']);

        Route::post('/get-cart-items', [OrderController::class, 'getCartItems']); 
        Route::post('/add-to-cart', [OrderController::class, 'addToCart']);
        Route::post('/remove-from-cart', [OrderController::class, 'deleteFromCart']);
        Route::post('/increase-quantity', [OrderController::class, 'increaseQuantity']);
        Route::post('/decrease-quantity', [OrderController::class, 'decreaseQuantity']);
        Route::delete('/order', [OrderController::class, 'deleteOrder']);
        Route::post('/checkout', [OrderController::class, 'checkout']);

        Route::get('/user-transactions', [TransactionController::class, 'getTransactions']);
    });  
});

// Fallback route for AngularJS
Route::get('/{any}', function () {
    return view('layouts.app'); // Main AngularJS layout
})->where('any', '.*');

