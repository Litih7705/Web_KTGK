<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

// Trang chủ hiển thị mặc định 20 laptop hoặc lọc theo danh mục
Route::get('/laptop/chitiet/{id}', [App\Http\Controllers\HomeController::class, 'detail'])->name('laptop.detail2');
Route::get('/laptop/danh-muc/{id}', [App\Http\Controllers\HomeController::class, 'index'])->name('laptop.category2');