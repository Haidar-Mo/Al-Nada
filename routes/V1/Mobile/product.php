<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Mobile\ProductController;

Route::prefix('mobile/product')->middleware('auth:sanctum')->group(function () {
    Route::get('index', [ProductController::class, 'index']);
    Route::get('show/{id}', [ProductController::class, 'show']);
    Route::post('buy/{id}', [ProductController::class, 'buyProduct']);
});
