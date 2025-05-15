<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Public Routes
Route::get('/', function () {
    return view('webfront.home');
});

// Web Pages (public access)
Route::prefix('')->group(function () {
    Route::view('/about', 'webfront.about')->name('about');
    Route::view('/blog', 'webfront.blog')->name('blog');
    Route::view('/blog-details', 'webfront.blog-details')->name('blog.details');
    Route::view('/shop', 'webfront.shop')->name('shop');
    Route::view('/shop-details', 'webfront.shop-details')->name('shop.details');
    Route::view('/contact', 'webfront.contact')->name('contact');
});

// Contact Form Route
Route::view('/contactform', 'webfront.contactform')->name('contactform');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email Verification Routes
Route::get('/email/verify', [AuthController::class, 'showVerifyEmail'])->name('verification.notice')->middleware('auth');
Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])->name('verification.send')->middleware(['auth', 'throttle:6,1']);
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify')->middleware(['auth', 'signed', 'throttle:6,1']);

// Password Reset Routes
Route::get('/password/reset', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Socialite Routes
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirectToProvider'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('socialite.callback');

// Customer Routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    // Shopping Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account/delete', [AuthController::class, 'deleteAccount'])->name('account.delete');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Staff Routes (requires staff role)
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':staff'])->group(function () {
    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');
    
    Route::get('/staff/orders', [OrderController::class, 'staffIndex'])->name('staff.orders.index');
    Route::put('/staff/orders/{order}', [OrderController::class, 'updateStatus'])->name('staff.orders.update');
});

// Manager Routes (requires manager role)
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':manager'])->group(function () {
    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    })->name('manager.dashboard');
    
    // Product Management
    Route::resource('products', ProductController::class);
    
    // Staff Management
    Route::get('/staff', [ProfileController::class, 'staffIndex'])->name('staff.index');
    Route::put('/staff/{user}/role', [RoleController::class, 'assignRole'])->name('staff.role.update');
    
    // Reports
    Route::get('/reports/sales', [OrderController::class, 'salesReport'])->name('reports.sales');
    Route::get('/reports/inventory', [ProductController::class, 'inventoryReport'])->name('reports.inventory');
});

// Admin Routes (requires admin role)
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // User Management
    Route::get('/users', [ProfileController::class, 'index'])->name('users.index');
    Route::get('/users/create', [ProfileController::class, 'create'])->name('users.create');
    Route::post('/users', [ProfileController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [ProfileController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [ProfileController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [ProfileController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [ProfileController::class, 'destroy'])->name('users.destroy');
    
    // Role Management
    Route::resource('roles', RoleController::class);
    
    // System Settings
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
    Route::put('/settings', [ProfileController::class, 'updateSettings'])->name('settings.update');
});

// Admin routes
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
});

// Manager routes
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('staff', StaffController::class);
    Route::get('/reports/sales', function () {
        return view('manager.reports.sales');
    })->name('reports.sales');
    Route::get('/reports/inventory', function () {
        return view('manager.reports.inventory');
    })->name('reports.inventory');
});

// Staff routes
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', function () {
        return view('staff.orders.index');
    })->name('orders');
    Route::get('/orders/{order}', function ($order) {
        return view('staff.orders.show', compact('order'));
    })->name('orders.show');
    Route::get('/customers', function () {
        return view('staff.customers.index');
    })->name('customers');
    Route::get('/inventory', function () {
        return view('staff.inventory.index');
    })->name('inventory');
});

// Customer routes
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':customer'])->group(function () {
    Route::get('/orders', function () {
        return view('customer.orders.index');
    })->name('orders');
    Route::get('/orders/{order}', function ($order) {
        return view('customer.orders.show', compact('order'));
    })->name('orders.show');
});

require __DIR__.'/auth.php';