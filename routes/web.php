<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('front.home');
})->name('front');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('prizes', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('clients', \App\Http\Controllers\Admin\ClientController::class);

});
Route::get('p-list', [\App\Http\Controllers\PrizeController::class, 'getPrizes']);

Route::post('prizes/check', [\App\Http\Controllers\PrizeController::class, 'checkPrize']);
Route::post('prizes/assign', [\App\Http\Controllers\PrizeController::class, 'assignPrize']);
Route::get('prizes/assign', [\App\Http\Controllers\PrizeController::class, 'assignPrize']);
