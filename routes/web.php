<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
Route::get('/', function () {
    return view('welcome');
});
Route::resource('products', ProductController::class);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use Illuminate\Support\Facades\Mail;

Route::get('/test-mail', function () {
    Mail::raw('Hoa Don Cua Ban:
                            MaHD:
                            Ten Dien Thoai:
                            Mau Sac:
                            Gia:
                            So Luong:
                            PT Thanh Toán:', function ($message) {
        $message->to('kydoana51922@gmail.com')
                ->subject('Thong bao hoa don');
    });

    return 'Sent!';
});


