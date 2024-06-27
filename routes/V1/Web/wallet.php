<?php

use App\Http\Controllers\Web\WalletChargeController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/wallet')->middleware('auth:sanctum', 'type.web')->group(function () {

    Route::prefix('charge-request')->group(function () {

        Route::get('index', [WalletChargeController::class, 'index']);
        Route::get('show/{id}', [WalletChargeController::class, 'show']);
        Route::post('accept/{id}',[WalletChargeController::class,'accept']);
        Route::put('reject/{id}',[WalletChargeController::class,'reject']);
    });
});
