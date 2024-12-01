<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

// After login routes to web page:
Route::get('/{id}', function () {
    return view('layouts.app');
})->name('homeLogin');
Route::get('/contact/{id}', function () {
    return view('layouts.app');
})->name('contactLogin');


// API Routes (for CRUD operations)
Route::prefix('api')->group(function () {
    Route::post('/register', [RegisterController::class, 'create']); 
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/contact', [ContactController::class, 'contact']);
    Route::get('/account-info/{id}', [LoginController::class, 'getAccountInfo']);
    Route::post('/admin-login', [AdminController::class, 'adminLogin']);
    Route::patch('/accountInfo-update/{id}', [AccountUpdateController::class, 'updateAccountInfo']);
    Route::patch('/accountLogin-update/{id}', [AccountUpdateController::class, 'updateAccountLogin']);
});

// Fallback route for AngularJS
Route::get('/{any}', function () {
    return view('layouts.app'); // Main AngularJS layout
})->where('any', '.*');

