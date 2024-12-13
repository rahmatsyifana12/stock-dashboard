<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/check-token', function () {
    if (session('api_token')) {
        return response()->json(['message' => 'Token found in session'], 200);
    }
    return response()->json(['message' => 'Token not found in session'], 200);
});

Route::get('/login', [AuthController::class, 'loginPage']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'registerPage']);
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/get-auth-claims', [AuthController::class, 'getAuthClaims'])->middleware('auth');

// view all products page
Route::get('/products', [ProductController::class, 'index'])->middleware('auth');

// create new product page
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('auth');

// add new product api
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// delete product api
Route::delete('/products/{id}', [ProductController::class, 'delete']);

// edit product page
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

// update product api
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
