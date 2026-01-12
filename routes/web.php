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
| ROOT & LANDING
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Nếu đã đăng nhập thì vào admin.home, chưa thì ra landing
    return auth()->check() ? redirect()->route('admin.home') : redirect()->route('landing');
});

Route::get('/landing', fn() => view('auth.landing'))->name('landing')->middleware('guest');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {


    Route::get('/landing', fn() => view('auth.landing'))->name('landing');

    // Login

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/verify-otp', [RegisterController::class, 'showVerifyOtpForm'])->name('otp.view');
    Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])->name('otp.resend');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| USER & SHOP ROUTES (Dành cho khách hàng)
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
    // Trang home sau đăng nhập (redirect sang shop để tránh 404)
    Route::get('/home', function () {
        return redirect()->route('shop.index');
    })->name('home');

    Route::get('/shop', function () {
        $categories = Product::all()->groupBy('brand');
        return view('client.index', compact('categories'));
    })->name('shop.index');

    Route::get('/san-pham/{id}', [ProductController::class, 'show'])->name('product.show');

    Route::get('/danh-muc/{id}', function ($id) {
        $products = Product::where('brand', ucfirst(str_replace('-', ' ', $id)))->paginate(12);
        return view('shop.category', compact('products', 'id'));
    })->name('shop.category');

    // Cart & Checkout
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::post('/update', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    });

    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/success/{id}', [CheckoutController::class, 'success'])->name('success');
    });
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Phần quản trị - Đã sửa lỗi)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard - Sửa thành 'home' để khớp với route('admin.home') trong sidebar
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // 2. Thống kê - PHẢI ĐỂ TRÊN RESOURCE để tránh lỗi Method show does not exist
    Route::get('/products/thong-ke', [ProductController::class, 'thongke'])->name('products.thongke');

    // 3. Quản lý sản phẩm (Resource tự động tạo index, create, edit...)
    Route::resource('products', ProductController::class);
});

/*
|--------------------------------------------------------------------------
| MAIL & TEST
|--------------------------------------------------------------------------
*/

Route::get('/test-email', [MailController::class, 'showTestForm'])->name('mail.test.form');
Route::post('/test-email/send', [MailController::class, 'sendTestEmail'])->name('mail.test.send');
Route::get('/send-welcome/{userId}', [MailController::class, 'sendWelcomeEmail'])->name('mail.welcome');

// Route chi tiết sản phẩm (slug để thân thiện URL)
Route::get('/san-pham/{id}', [ProductController::class, 'show'])->name('product.show');


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

// Thêm giỏ hàng
Route::post('cart/add/{product}', [CartController::class, 'add'])->name('cart.add');


