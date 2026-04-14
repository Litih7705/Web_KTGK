<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaptopController3;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

// Route chi tiết sản phẩm
Route::get('/laptop/chitiet/{id}', [LaptopController3::class, 'chiTiet']);

// Route tìm kiếm (Sửa thành POST cho khớp form trong layout của bạn)
Route::post('/timkiem', [LaptopController3::class, 'timKiem']);