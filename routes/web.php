<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================= ROOT =================
// Trang gốc: nếu login → home, chưa login → landing
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('home')
        : redirect()->route('landing');
});

// ================= AUTH =================
Route::get('/landing', function () {
    return view('auth.landing');
})->name('landing');

// ---------- LOGIN ----------
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest');

// ---------- REGISTER ----------
Route::get('/register', [RegisterController::class, 'showRegisterForm'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('guest');

// ---------- OTP ----------
Route::get('/verify-otp', [RegisterController::class, 'showVerifyOtpForm'])
    ->middleware('guest')
    ->name('otp.view');

Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])
    ->middleware('guest')
    ->name('otp.verify');

// RESEND OTP
Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])
    ->middleware('guest')
    ->name('otp.resend');

// ---------- LOGOUT ----------
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ================= AUTHENTICATED =================

// ---------- HOME ----------
Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');

// ---------- PRODUCTS ----------
Route::resource('products', ProductController::class)
    ->middleware('auth');

// ================= CART =================
// Routes cho giỏ hàng
Route::get('/cart', [CartController::class, 'index'])
    ->middleware('auth')
    ->name('cart.index');

Route::post('/cart/add/{product}', [CartController::class, 'add'])
    ->middleware('auth')
    ->name('cart.add');

Route::post('/cart/update', [CartController::class, 'update'])
    ->middleware('auth')
    ->name('cart.update');

Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])
    ->middleware('auth')
    ->name('cart.remove');

Route::delete('/cart/clear', [CartController::class, 'clear'])
    ->middleware('auth')
    ->name('cart.clear');

// ================= CHECKOUT =================
// Routes cho thanh toán (yêu cầu đăng nhập)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout/process', [CheckoutController::class, 'process'])
        ->name('checkout.process');

    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])
        ->name('checkout.success');
});

// ================= MAIL =================
Route::get('/test-email', [MailController::class, 'showTestForm'])
    ->name('mail.test.form');

Route::post('/test-email/send', [MailController::class, 'sendTestEmail'])
    ->name('mail.test.send');

// Gửi welcome email cho user
Route::get('/send-welcome/{userId}', [MailController::class, 'sendWelcomeEmail'])
    ->name('mail.welcome');
