<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
// Sửa lại: Nếu bạn dùng CheckoutController để quản lý đơn hàng luôn thì không cần gọi OrderController riêng lẻ
// Ở đây tôi dùng CheckoutController cho thống nhất với yêu cầu trước đó của bạn.

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
| CLIENT SIDE (SHOP, CART, CHECKOUT)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/home', fn() => redirect()->route('shop.index'))->name('home');

    Route::get('/shop', function () {
        $categories = Product::all()->groupBy('brand');
        return view('client.index', compact('categories'));
    })->name('shop.index');

    Route::get('/san-pham/{id}', [ProductController::class, 'show'])->name('product.show');

    Route::get('/danh-muc/{id}', function ($id) {
        $products = Product::where('brand', ucfirst(str_replace('-', ' ', $id)))->paginate(12);
        return view('shop.category', compact('products', 'id'));
    })->name('shop.category');

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
        Route::get('/success/{orderId}', [CheckoutController::class, 'success'])->name('success');
    });

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

    // 3. Quản lý Đơn hàng (ĐÃ ĐỒNG BỘ TÊN HÀM ĐỂ HẾT LỖI 500/404)
    Route::prefix('orders')->name('orders.')->group(function () {
        // Sửa 'index' thành 'adminOrders' hoặc 'adminIndex' tùy theo Controller của bạn
        // Để khớp với lỗi trong ảnh của bạn, tôi sử dụng 'adminOrders'
        Route::get('/', [CheckoutController::class, 'adminOrders'])->name('index');

        // Sửa hàm show chi tiết
        Route::get('/{id}', [CheckoutController::class, 'adminOrderDetail'])->name('show');

        // Thêm route cập nhật trạng thái đơn hàng
        Route::post('/{id}/update-status', [CheckoutController::class, 'updateStatus'])->name('updateStatus');
    });
});