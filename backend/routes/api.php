<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TenantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', static function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(static function() {
    Route::group(['prefix' => '/setting'], static function() {
        Route::put('/tables', [TenantController::class, 'changeTableCount']);
        Route::post('/items', [TenantController::class, 'createItem']);
        Route::patch('/items/{id}', [TenantController::class, 'updateItem']);
        Route::delete('/items/{id}', [TenantController::class, 'deleteItem']);
    });
});
