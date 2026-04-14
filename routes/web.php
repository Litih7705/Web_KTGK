<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
 main

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Đơn hàng, Thanh toán
Route::get('/order','App\Http\Controllers\LaptopOrderController@order')->name('order');
Route::post('/cart/add','App\Http\Controllers\LaptopOrderController@cartadd')->name('cartadd');
Route::post('/cart/delete','App\Http\Controllers\LaptopOrderController@cartdelete')->name('cartdelete');
Route::post('/order/create','App\Http\Controllers\LaptopOrderController@ordercreate') ->middleware('auth')->name('ordercreate');
Route::post('/laptopview','App\Http\Controllers\LaptopOrderController@laptopview')->name("laptopview");

// Trang chủ hiển thị mặc định 20 laptop hoặc lọc theo danh mục
Route::get('/laptop/chitiet/{id}', [App\Http\Controllers\HomeController::class, 'detail'])->name('laptop.detail2');
Route::get('/laptop/danh-muc/{id}', [App\Http\Controllers\HomeController::class, 'index'])->name('laptop.category2');

require __DIR__.'/auth.php';