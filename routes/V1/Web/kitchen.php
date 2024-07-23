<?php

use App\Http\Controllers\Web\KitchenController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/kitchen')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [KitchenController::class, 'index']);
    Route::get('show/{id}', [KitchenController::class, 'show']);
    Route::post('create', [KitchenController::class, 'store']);
    Route::post('update/{id}', [KitchenController::class, 'update']);
    Route::put('make-available/{id}', [KitchenController::class, 'makeAvailable']);
    Route::put('make-not-available/{id}', [KitchenController::class, 'makeNotAvailable']);
    Route::delete('delete/{id}', [KitchenController::class, 'destroy']);
});