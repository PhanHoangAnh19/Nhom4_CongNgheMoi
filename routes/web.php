<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserRegisterController;

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

    Route::get('/landing', fn() => view('auth.landing'))->name('landing');

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
