<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// Redirect dari halaman utama ke halaman login admin
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Rute Login Admin
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);

// Rute yang dilindungi oleh middleware 'auth' dan 'admin'
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    
    // Rute API (AJAX) untuk manajemen menu
    Route::get('/menus/list', [MenuController::class, 'list'])->name('menus.list');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
    
    // Rute API (AJAX) untuk manajemen pesanan
    Route::get('/orders/list', [OrderController::class, 'list'])->name('orders.list');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');