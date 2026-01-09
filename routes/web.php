<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================= LANDING =================
Route::get('/landing', function () {
    return view('auth.landing');
})->name('landing');

// ================= ROOT =================
// Chưa login → landing
// Login admin → home
// Login user → chặn (chưa có web user)
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('landing');
    }

    return auth()->user()->role === 'admin'
        ? redirect()->route('home')
        : abort(403, 'User chưa có giao diện');
});

// ================= AUTH =================

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

Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])
    ->middleware('guest')
    ->name('otp.resend');

// ---------- LOGOUT ----------
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ================= ADMIN (HOME = DASHBOARD) =================

// ---------- HOME (ADMIN ONLY) ----------
Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('home');

// ---------- PRODUCTS (ADMIN ONLY) ----------
Route::resource('products', ProductController::class)
    ->middleware(['auth', 'admin']);
