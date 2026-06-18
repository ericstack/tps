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
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // --- Open to any authenticated user ---
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::get('employees/next-code', [EmployeeController::class, 'nextCode']);
    Route::apiResource('employees', EmployeeController::class);
    // Tasks stay open; per-task status/comment is gated by TaskPolicy in the controller.
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus']);
    Route::get('tasks/{task}/comments', [TaskController::class, 'comments']);
    Route::post('tasks/{task}/comments', [TaskController::class, 'storeComment']);
    Route::apiResource('tasks', TaskController::class);

    // --- Role-gated modules (config/roles.php) ---
    Route::middleware('module:inventory_products')->group(function () {
        Route::apiResource('inventory', InventoryController::class);
        Route::apiResource('products', ProductController::class);
    });
    Route::middleware('module:orders')->group(function () {
        Route::apiResource('orders', OrderController::class);
    });
    Route::middleware('module:deliveries')->group(function () {
        Route::apiResource('deliveries', DeliveryController::class);
    });
    Route::middleware('module:purchase_orders')->group(function () {
        Route::apiResource('purchase-orders', PurchaseOrderController::class);
    });

    // --- Admin-only user management ---
    Route::middleware('admin')->group(function () {
        Route::post('users/provision', [UserController::class, 'provision']);
        Route::apiResource('users', UserController::class);
    });
});
