<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth Routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('password/reset', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('password/send-otp', [\App\Http\Controllers\Auth\PasswordResetController::class, 'sendOtp'])->name('password.send-otp');
Route::get('password/verify', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showVerifyForm'])->name('password.verify.form');
Route::post('password/verify-otp', [\App\Http\Controllers\Auth\PasswordResetController::class, 'verifyOtp'])->name('password.verify-otp');
Route::get('password/reset-form', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('password/update', [\App\Http\Controllers\Auth\PasswordResetController::class, 'resetPassword'])->name('password.update');

// Public Routes
Route::get('/', [\App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/p/{slug}', [\App\Http\Controllers\Web\PageController::class, 'show'])->name('pages.show');
Route::post('/contact-query', [\App\Http\Controllers\Web\ContactQueryController::class, 'store'])->name('contact.query.store');

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\Web\CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{cart}', [App\Http\Controllers\Web\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cart}', [App\Http\Controllers\Web\CartController::class, 'remove'])->name('cart.remove');
    
    // Reviews
    Route::post('/products/{product}/reviews', [App\Http\Controllers\Web\ReviewController::class, 'store'])->name('reviews.store');
    
    // Checkout
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // User Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Products & Categories Management (Restricted to Inventory Manager)
    Route::middleware('inventory_manager')->group(function () {
        Route::resource('products', AdminProductController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('queries', \App\Http\Controllers\Admin\ContactQueryController::class)->only(['index', 'show', 'destroy']);
        Route::resource('team-members', \App\Http\Controllers\Admin\TeamMemberController::class);
    });
    
    // Orders Management
    Route::get('orders/{order}/invoice', [\App\Http\Controllers\Admin\OrderController::class, 'generateInvoice'])->name('orders.invoice');
    Route::post('orders/{order}/assign', [\App\Http\Controllers\Admin\OrderController::class, 'assign'])->name('orders.assign');
    Route::post('orders/{order}/unassign', [\App\Http\Controllers\Admin\OrderController::class, 'unassign'])->name('orders.unassign');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->middleware('super_admin')->name('orders.destroy');
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    
    // Users Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->middleware('super_admin');

    // Admin Profile
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

    // Content Pages
    Route::middleware('super_admin')->resource('pages', \App\Http\Controllers\Admin\PageController::class)->only(['index', 'edit', 'update']);
});
