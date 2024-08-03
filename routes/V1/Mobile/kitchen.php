<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Mobile\KitchenController;

Route::prefix('mobile/dish')->middleware([
    'auth:sanctum',
    'type.mobile',
    'isActive'
])->group(function () {

    Route::get('index', [KitchenController::class, 'index']);
    Route::get('show/{id}', [KitchenController::class, 'show']);
    Route::post('buy/{id}', [KitchenController::class, 'orderProduct']);
});
