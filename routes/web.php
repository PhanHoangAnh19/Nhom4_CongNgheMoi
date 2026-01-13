<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderController;

/*
|--------------------------------------------------------------------------
| ROOT & LANDING
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return auth()->check() ? redirect()->route('admin.home') : redirect()->route('landing');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION (GUEST)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/landing', fn() => view('auth.landing'))->name('landing');
    
    // Login & Register
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // OTP
    Route::get('/verify-otp', [RegisterController::class, 'showVerifyOtpForm'])->name('otp.view');
    Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])->name('otp.resend');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| CLIENT SIDE (SHOP, CART, CHECKOUT)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Chuyển hướng home mặc định
    Route::get('/home', fn() => redirect()->route('shop.index'))->name('home');

    // Shop & Product Detail
    Route::get('/shop', function () {
        $categories = Product::all()->groupBy('brand');
        return view('client.index', compact('categories'));
    })->name('shop.index');

    Route::get('/san-pham/{id}', [ProductController::class, 'show'])->name('product.show');

    Route::get('/danh-muc/{id}', function ($id) {
        $products = Product::where('brand', ucfirst(str_replace('-', ' ', $id)))->paginate(12);
        return view('shop.category', compact('products', 'id'));
    })->name('shop.category');

    // Cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::post('/update', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    });

    // Checkout
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/success/{orderId}', [CheckoutController::class, 'success'])->name('success');
    });

    // Lịch sử đơn hàng dành cho khách hàng
    Route::get('/order-history', [CheckoutController::class, 'history'])->name('order.history');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (QUẢN TRỊ)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // 2. Quản lý sản phẩm & Thống kê
    Route::get('/products/thong-ke', [ProductController::class, 'thongke'])->name('products.thongke');
    Route::resource('products', ProductController::class);

    // 3. Quản lý Đơn hàng (Admin)
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::patch('/{id}/update-status', [OrderController::class, 'updateStatus'])->name('updateStatus');
    });
});