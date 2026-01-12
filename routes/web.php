<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.home')
        : redirect()->route('landing');
});

/*
|--------------------------------------------------------------------------
| AUTH (GUEST)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/landing', fn () => view('auth.landing'))->name('landing');

    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // OTP
    Route::get('/verify-otp', [RegisterController::class, 'showVerifyOtpForm'])->name('otp.view');
    Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])->name('otp.resend');
});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        // Dashboard
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        // Products (ADMIN)
        Route::get('/products/thong-ke', [ProductController::class, 'thongKe'])
            ->name('products.thongke');

        Route::resource('products', ProductController::class);
});

/*
|--------------------------------------------------------------------------
| CLIENT / SHOP
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/shop', function () {
        // Lấy tất cả sản phẩm và group theo brand
        $categories = Product::all()->groupBy('brand');
        
        // Truyền $categories vào view
        return view('client.index', compact('categories'));
    })->name('shop.index');
});

/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/
Route::get('/home-test', function () {
    $categories = [
        'Laptop' => \App\Models\Product::where('brand', 'Dell')->take(4)->get(),
        'Điện thoại' => \App\Models\Product::where('brand', 'Apple')->take(4)->get(),
        'Phụ kiện' => \App\Models\Product::where('brand', 'Logitech')->take(4)->get(),
    ];
    return view('home', compact('categories'));
})->name('home.test');

// Giỏ hàng routes - Phải đặt trong middleware auth
Route::middleware('auth')->prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Thanh toán routes - Phải đặt trong middleware auth
Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    // THAY ĐỔI TỪ {id} THÀNH {orderId} ĐỂ KHỚP VỚI CONTROLLER
    Route::get('/success/{orderId}', [CheckoutController::class, 'success'])->name('success');
});

/*
|--------------------------------------------------------------------------
| MAIL
|--------------------------------------------------------------------------
*/
Route::get('/test-email', [MailController::class, 'showTestForm'])
    ->name('mail.test.form');

Route::post('/test-email/send', [MailController::class, 'sendTestEmail'])
    ->name('mail.test.send');

Route::get('/send-welcome/{userId}', [MailController::class, 'sendWelcomeEmail'])
    ->name('mail.welcome');