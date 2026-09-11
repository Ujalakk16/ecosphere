<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\App;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Ye routes login se pehle accessible hone chahiye
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Admin Routes (Products Management)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/users', [ProductController::class, 'users'])->name('users');
}); 

Route::get('admin/profile/{id}', [ProfileController::class, 'show'])->name('admin.user-profile');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

Route::get('/home', function () {
    return redirect('/'); 
});

// Authentication & Social Login Routes Group
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('/auth/google/callback', 'handleGoogleCallback');
    Route::get('/auth/facebook', 'redirectToFacebook')->name('auth.facebook');
    Route::get('/auth/facebook/callback', 'handleFacebookCallback');
});

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{id}/purchase', [ProductController::class, 'purchase'])->name('products.purchase');
Route::get('/analytics', [ProductController::class, 'analytics'])->name('analytics');
Route::get('/cart', [ProductController::class, 'viewCart'])->name('cart.products');
Route::post('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}', [ProductController::class, 'remove'])->name('cart.remove');

Route::post('/checkout', [ProductController::class, 'checkout'])
    ->middleware('auth')
    ->name('checkout');

Route::get('/checkout-success', [ProductController::class, 'success'])
    ->middleware('auth')
    ->name('checkout.success');

Route::post('/products/{product}/simulate', [ProductController::class, 'simulate'])->name('products.simulate');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ur', 'zh'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');