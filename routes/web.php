<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiTunaiController;
use App\Http\Controllers\Owner\CashierOwnerController;
use App\Http\Controllers\Owner\ProductOwnerController;
use App\Http\Controllers\Owner\DashboardOwnerController;
use App\Http\Controllers\Karyawan\DashboardKaryawanController;
use App\Http\Controllers\Owner\StockOwnerController;
use App\Http\Controllers\TransaksiQrisController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Owner Route

Route::resource('owner/dashboard', DashboardOwnerController::class, [
    'as' => 'owner'
]);

Route::resource('owner/cashier', CashierOwnerController::class, [
    'as' => 'owner'
]);

Route::resource('owner/product', ProductOwnerController::class, [
    'as'=> 'owner'
]);

Route::resource('owner/transaksitunai', TransaksiTunaiController::class, [
    'as' => 'owner'
]);

Route::resource('owner/transaksiqris', TransaksiQrisController::class, [
    'as'=> 'owner'
]);

Route::resource('owner/stock', StockOwnerController::class, [
    'as'=> 'owner'
]);

Route::patch('owner/stock/increment/{id}', [StockOwnerController::class, 'incrementQty'])->name('owner.stock.increment');

Route::patch('owner/stock/decrement/{id}', [StockOwnerController::class, 'decrementQty'])->name('owner.stock.decrement');

require __DIR__.'/auth.php';
