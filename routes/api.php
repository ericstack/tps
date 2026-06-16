<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// --- Public auth endpoints (session/cookie based via Sanctum SPA) ---
Route::post('/login', [AuthController::class, 'login']);

// --- Authenticated endpoints ---
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('inventory', InventoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('employees', EmployeeController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('deliveries', DeliveryController::class);
    Route::apiResource('purchase-orders', PurchaseOrderController::class);

    // Admin-only user management (access === 1 in the legacy schema).
    Route::middleware('role:1')->group(function () {
        Route::apiResource('users', UserController::class);
    });
});
