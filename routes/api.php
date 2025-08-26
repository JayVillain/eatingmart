<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'API is working',
        'timestamp' => now()
    ]);
});

// Rute Publik untuk Pelanggan (Tidak memerlukan login)
Route::post('/customer/register', [AuthController::class, 'register']);
Route::post('/customer/login', [AuthController::class, 'apiLogin']);
Route::get('/customer/menu', [MenuController::class, 'list']);

// Rute yang Dilindungi (Memerlukan token Sanctum)
Route::middleware('auth:sanctum')->prefix('customer')->group(function () {
    // Profile routes
    Route::get('/profile', function (Request $request) {
        return response()->json([
            'user' => $request->user(),
            'message' => 'Profile retrieved successfully'
        ]);
    });
    
    // Checkout route
    Route::post('/checkout', [OrderController::class, 'checkout']);
    
    // Order history
    Route::get('/orders', [OrderController::class, 'customerOrders']);
});