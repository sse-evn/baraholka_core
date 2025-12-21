<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;

Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);

    Route::post('/orders', [OrderController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
});
