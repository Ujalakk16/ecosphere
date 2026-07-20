<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\App;





Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// Ye routes login se pehle accessible hone chahiye
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Admin Routes (Products Management)
// Sahi aur saaf tareeqa
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
// Products CRUD Routes
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

// Agar aapka home page '/' hai, toh isay add karein:
Route::get('/home', function () {
    return redirect('/'); 
});


// Authentication & Social Login Routes Group
Route::controller(AuthController::class)->group(function () {
    // Login Routes
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');

    // Register Routes
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');

    // Logout Route
    Route::post('/logout', 'logout')->name('logout');

    // Google Social Login Routes
    Route::get('/auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('/auth/google/callback', 'handleGoogleCallback');

    // Facebook Social Login Routes
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
    ->middleware('auth') // Yeh line user ko login page par redirect kar degi agar woh logged-in nahi hai
    ->name('checkout');

Route::get('/checkout-success', [ProductController::class, 'success'])
    ->middleware('auth') // Success page bhi sirf logged-in users ke liye hona chahiye
    ->name('checkout.success');


Route::post('/products/{product}/simulate', [ProductController::class, 'simulate'])->name('products.simulate');
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ur', 'zh'])) {
        session(['locale' => $locale]); // Yeh session update kar dega
    }
    return redirect()->back();
})->name('lang.switch');

