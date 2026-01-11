<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserRegisterController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('landing');
    }

    return auth()->user()->role === 'admin'
        ? redirect()->route('home')
        : redirect()->route('shop.index');
});

/*
|--------------------------------------------------------------------------
| AUTH (GUEST)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/landing', fn () => view('auth.landing'))->name('landing');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

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
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/products/thong-ke', [ProductController::class, 'thongKe'])
        ->name('products.thongke');

    Route::resource('products', ProductController::class);
});

/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

/*
|--------------------------------------------------------------------------
| SHOP
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/shop', function () {
        $categories = Product::all()->groupBy('brand');
        return view('client.index', compact('categories'));
    })->name('shop.index');
});

/*
|--------------------------------------------------------------------------
| REGISTER USER (RIÊNG)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/register-user', [UserRegisterController::class, 'showForm'])
        ->name('user.register');

    Route::post('/register-user', [UserRegisterController::class, 'register'])
        ->name('user.register.submit');

    Route::get('/verify-user-otp', [UserRegisterController::class, 'showVerifyOtpForm'])
        ->name('user.otp.view');

    Route::post('/verify-user-otp', [UserRegisterController::class, 'verifyOtp'])
        ->name('user.otp.verify');

    Route::post('/resend-user-otp', [UserRegisterController::class, 'resendOtp'])
        ->name('user.otp.resend');
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
