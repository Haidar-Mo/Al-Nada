<?php

use App\Http\Controllers\Web\OrderController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/order')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [OrderController::class, 'index']);
    Route::get('show/{id}', [OrderController::class, 'show'])->name('web.order.show');
    Route::post('status/{id}', [OrderController::class, 'statusChange']);
    //Route::delete('delete/{id}', [OrderController::class, 'destroy']);
});
