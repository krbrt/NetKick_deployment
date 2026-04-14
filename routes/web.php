<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductDisplayController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $products = Product::where('quantity', '>', 0)->latest()->take(10)->get();
    return view('welcome', compact('products'));
})->name('welcome');

Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/about', 'about')->name('about');

// User Display Routes (Shop, Categories)
Route::name('hn.')->controller(ProductDisplayController::class)->group(function () {
    Route::redirect('/shop', '/featured', 301)->name('index');
    Route::get('/featured', 'featured')->name('featured');
    Route::get('/clothes', 'clothes')->name('clothes');
    Route::get('/shoes', 'shoes')->name('shoes');
    Route::get('/crocs', 'crocs')->name('crocs');
    Route::get('/sale', 'sale')->name('sale');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Customers)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // CART SYSTEM - Inayos ang routes para sa Database-driven Cart
    Route::prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/add', 'store')->name('store');
        Route::post('/buy-now', 'buyNow')->name('buyNow');
        Route::patch('/update', 'update')->name('update'); // Para sa qty adjustment
        Route::delete('/remove/{id}', 'destroy')->name('destroy');
        Route::post('/apply-voucher', 'applyVoucher')->name('applyVoucher'); // NEW: Para sa discounts
    });

    // CHECKOUT SYSTEM
    Route::prefix('checkout')->name('checkout.')->controller(CheckoutController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/process', 'process')->name('process'); // COD only
        Route::get('/success', 'success')->name('success');
    });

    // CUSTOMER ORDERS - Tracking ng binili ng user
    Route::prefix('my-orders')->name('orders.')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{order_number}', 'show')->name('show');
        Route::patch('/{id}/cancel', 'cancel')->name('cancel'); // NEW: Option para sa user na mag-cancel
    });

    // PROFILE & SECURITY
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/security', function () {
            return view('profile.security');
        })->name('security');

        Route::controller(ProfileController::class)->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::patch('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Staff Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Main Admin Dashboard & General Management
    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('home');
        Route::get('/inventory', 'inventory')->name('inventory');
        Route::get('/reports', 'reports')->name('reports');
        Route::get('/customers', 'customers')->name('customers');
        Route::post('/banner/update', 'updateBanner')->name('banner.update');

        // Order Management for Admin
        Route::get('/orders', 'orders')->name('orders.index');
        Route::get('/orders/{id}', 'orderDetails')->name('orders.show');
        Route::patch('/orders/{id}/status', 'updateOrderStatus')->name('orders.updateStatus');
    });

    // Product CRUD - Full Management
    Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function() {
        Route::get('/', 'index')->name('index'); // NEW: Product list for admin
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    // Sales & Promotions
    Route::prefix('sales')->name('sales.')->controller(AdminController::class)->group(function() {
        Route::get('/', 'sales')->name('index');
        Route::post('/quick-add', 'quickAdd')->name('quick-add');
        Route::match(['post', 'patch'], '/toggle/{id}', 'toggleSale')->name('toggle');
    });

    // Voucher Management
    Route::prefix('vouchers')->name('vouchers.')->controller(AdminController::class)->group(function() {
        Route::get('/', 'vouchers')->name('index');
        Route::post('/store', 'storeVoucher')->name('store');
        Route::delete('/destroy/{id}', 'destroyVoucher')->name('destroy');
    });
});

require __DIR__.'/auth.php';
