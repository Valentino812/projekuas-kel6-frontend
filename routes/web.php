<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

// After login routes to web page:
Route::get('/{id}', function () {
    return view('layouts.app');
})->name('homeLogin');
Route::get('/contact/{id}', function () {
    return view('layouts.app');
})->name('contactLogin');
Route::get('/admin/{id}', function () {
    return view('layouts.app');
})->name('admin');
Route::get('/products/{id}', function () {
    return view('layouts.app');
})->name('productsLogin');

// API Routes (for CRUD operations)
Route::prefix('api')->group(function () {
    Route::post('/register', [AccountController::class, 'create']); 
    Route::post('/login', [AccountController::class, 'login']);
    Route::post('/contact', [ContactController::class, 'contact']);
    Route::get('/contacts', [ContactController::class, 'getAllContacts']);
    Route::get('/account-info/{id}', [AccountController::class, 'getAccountInfo']);
    Route::post('/admin-login', [AdminController::class, 'adminLogin']);
    Route::patch('/accountInfo-update/{id}', [AccountController::class, 'updateAccountInfo']);
    Route::patch('/accountLogin-update/{id}', [AccountController::class, 'updateAccountLogin']);
    Route::delete('/accountDelete/{id}', [AccountController::class, 'deleteAccount']);
    Route::post('/product', [ProductController::class, 'addProduct']);
    Route::get('/products', [ProductController::class, 'getAllProducts']);
    Route::get('/product/{id}', [ProductController::class, 'getProduct']);
    Route::post('/add-to-cart', [OrderController::class, 'addToCart']);
    Route::post('/checkout', [OrderController::class, 'checkout']);
    Route::get('/api/orders', [AdminController::class, 'getOrders']);
    Route::post('/update-product/{id}', [AdminController::class, 'updateProduct']);
    Route::delete('/delete-product/{id}', [AdminController::class, 'deleteProduct']);
});

// Fallback route for AngularJS
Route::get('/{any}', function () {
    return view('layouts.app'); // Main AngularJS layout
})->where('any', '.*');

