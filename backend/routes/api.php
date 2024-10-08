<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TenantController;
use App\Http\Middleware\EnsureJWTIsValid;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

// JWTトークンが必要なAPI
Route::middleware(EnsureJWTIsValid::class)->group(static function () {
    Route::get('/items', [ItemController::class, 'listItems']);
    Route::post('/orders/items', [OrderController::class, 'takeOrderItem']);
});

// ログイン認証が必要なAPI
Route::middleware('auth:sanctum')->group(static function() {
    Route::group(['prefix' => '/setting'], static function() {
        Route::put('/tables', [TenantController::class, 'changeTableCount']);
        Route::post('/items', [TenantController::class, 'createItem']);
        Route::patch('/items/{id}', [TenantController::class, 'updateItem']);
        Route::delete('/items/{id}', [TenantController::class, 'deleteItem']);
    });

    Route::group(['prefix' => '/orders'], static function() {
        Route::post('', [OrderController::class, 'initializeOrder']);
        Route::get('', [OrderController::class, 'getTableOrderItems']);
        Route::put('/{order_id}/items/{order_item_id}', [OrderController::class, 'updateOrderItem']);
    });
    Route::post('/checkout', [OrderController::class, 'checkout']);
});

// JWTトークンとログイン認証が必要なAPI
Route::middleware(['auth:sanctum', EnsureJWTIsValid::class])->group(static function() {
    Route::get('/checkout', [OrderController::class, 'getCheckout']);
});
