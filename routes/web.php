<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaptopOrderController;


Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/order','App\Http\Controllers\LaptopOrderController@order')->name('order');
Route::post('/cart/add','App\Http\Controllers\LaptopOrderController@cartadd')->name('cartadd');
Route::post('/cart/delete','App\Http\Controllers\LaptopOrderController@cartdelete')->name('cartdelete');
Route::post('/order/create','App\Http\Controllers\LaptopOrderController@ordercreate') ->middleware('auth')->name('ordercreate');
Route::post('/laptopview','App\Http\Controllers\LaptopOrderController@laptopview')->name("laptopview");
require __DIR__.'/auth.php';
