<?php

use App\Http\Controllers\Karyawan\DashboardKaryawanController;
use App\Http\Controllers\Owner\CashierOwnerController;
use App\Http\Controllers\Owner\DashboardOwnerController;
use App\Http\Controllers\Owner\ProductOwnerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

require __DIR__.'/auth.php';
