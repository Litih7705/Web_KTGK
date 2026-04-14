<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//2
// Trang chủ hiển thị mặc định 20 laptop hoặc lọc theo danh mục



Route::get('/laptop/chitiet/{id}', [App\Http\Controllers\HomeController::class, 'detail'])->name('laptop.detail2');

Route::get('/laptop/danh-muc/{id}', [App\Http\Controllers\HomeController::class, 'index'])->name('laptop.category2');