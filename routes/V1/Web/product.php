<?php

use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/product')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [ProductController::class, 'index']);
    Route::get('show/{id}', [ProductController::class, 'show']);
    Route::post('create', [ProductController::class, 'store']);
    Route::post('update/{id}', [ProductController::class, 'update']);
    Route::put('make-available/{id}', [ProductController::class, 'makeAvailable']);
    Route::put('make-not-available/{id}', [ProductController::class, 'makeNotAvailable']);
    Route::delete('delete/{id}', [ProductController::class, 'destroy']);
});
