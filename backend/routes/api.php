<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TenantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::group(['prefix' => '/setting'], function() {
        Route::put('/tables', [TenantController::class, 'changeTableCount']);
        Route::post('/items', [TenantController::class, 'createItem']);
    });
});
