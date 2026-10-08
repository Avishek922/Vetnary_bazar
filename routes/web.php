<?php

use Illuminate\Support\Facades\Route;

// Auth Controllers
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;

// Web Controllers
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\ContactQueryController;
use App\Http\Controllers\Web\ReviewController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ContactQueryController as AdminContactQueryController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\PageController as AdminPageController;

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
Route::post('login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->middleware('throttle:register');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('password/reset', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('password/send-otp', [PasswordResetController::class, 'sendOtp'])->middleware('throttle:otp-send')->name('password.send-otp');
Route::get('password/verify', [PasswordResetController::class, 'showVerifyForm'])->name('password.verify.form');
Route::post('password/verify-otp', [PasswordResetController::class, 'verifyOtp'])->middleware('throttle:otp-verify')->name('password.verify-otp');
Route::get('password/reset-form', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('password/update', [PasswordResetController::class, 'resetPassword'])->name('password.update');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/p/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::post('/contact-query', [ContactQueryController::class, 'store'])->middleware('throttle:contact')->name('contact.query.store');

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    // Reviews
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->middleware('throttle:reviews')->name('reviews.store');

    // Checkout
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'store'])->middleware('throttle:checkout')->name('checkout.store');

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
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('queries', AdminContactQueryController::class)->only(['index', 'show', 'destroy']);
        Route::resource('team-members', AdminTeamMemberController::class);
    });

    // Orders Management
    Route::get('orders/{order}/invoice', [AdminOrderController::class, 'generateInvoice'])->name('orders.invoice');
    Route::post('orders/{order}/assign', [AdminOrderController::class, 'assign'])->name('orders.assign');
    Route::post('orders/{order}/unassign', [AdminOrderController::class, 'unassign'])->name('orders.unassign');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->middleware('super_admin')->name('orders.destroy');
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);

    // Users Management
    Route::resource('users', AdminUserController::class)->middleware('super_admin');

    // Admin Profile
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // Content Pages
    Route::middleware('super_admin')->resource('pages', AdminPageController::class)->only(['index', 'edit', 'update']);
});
