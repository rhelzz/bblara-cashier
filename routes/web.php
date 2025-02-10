<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiTunaiController;
use App\Http\Controllers\Owner\CashierOwnerController;
use App\Http\Controllers\Owner\ProductOwnerController;
use App\Http\Controllers\Owner\DashboardOwnerController;
use App\Http\Controllers\Karyawan\DashboardKaryawanController;
use App\Http\Controllers\Owner\ReportOwnerController;
use App\Http\Controllers\Owner\StockOwnerController;
use App\Http\Controllers\Owner\UserOwnerController;
use App\Http\Controllers\TransaksiQrisController;
use App\Http\Controllers\Owner\ProfileOwnerController;

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

Route::resource('owner/user', UserOwnerController::class, [
    'as' => 'owner'
]);

Route::resource('owner/report', ReportOwnerController::class, [
    'as' => 'owner'
]);

Route::patch('owner/stock/increment/{id}', [StockOwnerController::class, 'incrementQty'])->name('owner.stock.increment');

Route::patch('owner/stock/decrement/{id}', [StockOwnerController::class, 'decrementQty'])->name('owner.stock.decrement');

// Owner Routes
Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileOwnerController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileOwnerController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileOwnerController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/destroy', [ProfileOwnerController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
