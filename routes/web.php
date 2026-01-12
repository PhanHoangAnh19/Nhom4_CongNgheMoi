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
        ? redirect()->route('home')
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
| HOME + PRODUCTS (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('products', ProductController::class);
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
| CART
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
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

/*
|--------------------------------------------------------------------------
| CHI TIẾT SẢN PHẨM
|--------------------------------------------------------------------------
*/
Route::get('/san-pham/{id}', [ProductController::class, 'show'])
    ->name('product.show');

Route::get('/danh-muc/{id}', function ($id) {
    $products = Product::where('brand', ucfirst(str_replace('-', ' ', $id)))
        ->paginate(12);

    return view('shop.category', compact('products', 'id'));
})->name('shop.category');
