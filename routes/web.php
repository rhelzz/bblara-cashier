<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiQrisController;
use App\Http\Controllers\TransaksiTunaiController;
use App\Http\Controllers\Owner\UserOwnerController;
use App\Http\Controllers\Owner\StockOwnerController;
use App\Http\Controllers\Owner\ReportOwnerController;
use App\Http\Controllers\Owner\CashierOwnerController;
use App\Http\Controllers\Owner\ProductOwnerController;
use App\Http\Controllers\Owner\ProfileOwnerController;
use App\Http\Controllers\Owner\DashboardOwnerController;
use App\Http\Controllers\Owner\NotificationOwnerController;
use App\Http\Controllers\Karyawan\CashierKaryawanController;
use App\Http\Controllers\Karyawan\NotificationKaryawanController;
use App\Http\Controllers\Karyawan\ProfileKaryawanController;
use App\Http\Controllers\Owner\MenuBestSellerOwnerController;

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

Route::middleware(['auth'])->prefix('karyawan')->name('karyawan.')->group(function (){

    // Cashier
    Route::resource('cashier', CashierKaryawanController::class);

    // Profile
    Route::get('profile', [ProfileKaryawanController::class, 'index'])->name('profile.index');
    Route::put('profile/update', [ProfileKaryawanController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileKaryawanController::class, 'updatePassword'])->name('profile.password');
    Route::delete('profile/destroy', [ProfileKaryawanController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::resource('notification', NotificationKaryawanController::class);
    Route::get('notifications/unread-count', [NotificationKaryawanController::class, 'unreadCount']);
    Route::post('notifications/mark-as-read', [NotificationKaryawanController::class, 'markAsRead']);
    Route::post('notifications/clear-all', [NotificationKaryawanController::class, 'clearAll']);
});

// Owner Routes
Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {
    
    // Dashboard
    Route::resource('dashboard', DashboardOwnerController::class);
    
    // Cashier
    Route::resource('cashier', CashierOwnerController::class);
    
    // Product
    Route::resource('product', ProductOwnerController::class);
    
    // Transactions
    Route::resource('transaksitunai', TransaksiTunaiController::class);
    Route::resource('transaksiqris', TransaksiQrisController::class);
    
    // Stock
    Route::resource('stock', StockOwnerController::class);
    Route::patch('stock/increment/{id}', [StockOwnerController::class, 'incrementQty'])->name('stock.increment');
    Route::patch('stock/decrement/{id}', [StockOwnerController::class, 'decrementQty'])->name('stock.decrement');
    
    // User
    Route::resource('user', UserOwnerController::class);
    
    // Report
    Route::resource('report', ReportOwnerController::class);
    
    // Notifications
    Route::resource('notification', NotificationOwnerController::class);
    Route::get('notifications/unread-count', [NotificationOwnerController::class, 'unreadCount']);
    Route::post('notifications/mark-as-read', [NotificationOwnerController::class, 'markAsRead']);
    Route::post('notifications/clear-all', [NotificationOwnerController::class, 'clearAll']);
    
    // Profile
    Route::get('profile', [ProfileOwnerController::class, 'index'])->name('profile.index');
    Route::put('profile/update', [ProfileOwnerController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileOwnerController::class, 'updatePassword'])->name('profile.password');
    Route::delete('profile/destroy', [ProfileOwnerController::class, 'destroy'])->name('profile.destroy');

    Route::resource('menu-best-sellers', MenuBestSellerOwnerController::class);
});

require __DIR__.'/auth.php';
