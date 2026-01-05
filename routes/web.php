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
    Mail::raw('Đây là mail test từ Laravel', function ($message) {
        $message->to('kydoana51922@gmail.com')
                ->subject('Test gửi mail Laravel');
    });

    return 'Đã gửi mail (nếu không lỗi)';
});

