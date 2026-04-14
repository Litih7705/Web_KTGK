<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaptopController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route:: middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// LaptopController Hiển thị danh sách
Route::get('/admin/laptop', [LaptopController::class, 'index'])->name('admin.index');
Route::get('/admin/laptop/{id}', [LaptopController::class, 'show'])->name('admin.show');
Route::delete('/admin/laptop/{id}', [LaptopController::class, 'destroy'])->name('admin.destroy');

require __DIR__.'/auth.php';
