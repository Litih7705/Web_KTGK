<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaptopController3;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaptopController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route chi tiết sản phẩm, tìm kiếm 
Route::get('/laptop/chitiet/{id}', [LaptopController3::class, 'chiTiet']);
Route::post('/timkiem', [LaptopController3::class, 'timKiem']);

//Profile
Route:: middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// LaptopController Hiển thị danh sách
Route::get('/admin/laptop', [LaptopController::class, 'index'])->name('admin.index');
Route::delete('/admin/laptop/{id}', [LaptopController::class, 'destroy'])->name('admin.destroy');

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
