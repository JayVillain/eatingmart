<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::post('/customer/register', [AuthController::class, 'register']);
Route::post('/customer/login', [AuthController::class, 'login']);
Route::get('/customer/menu', [MenuController::class, 'index']);
Route::middleware('auth:sanctum')->prefix('customer')->group(function () {
    Route::post('/checkout', [OrderController::class, 'checkout']);
});
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::middleware(['auth:sanctum', 'ability:admin'])->prefix('admin')->group(function () {
    Route::apiResource('menus', MenuController::class);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus']);
});