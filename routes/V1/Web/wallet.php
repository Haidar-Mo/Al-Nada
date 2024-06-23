<?php

use App\Http\Controllers\Web\WalletChargeController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/wallet')->middleware('auth:sanctum')->group(function () {

    Route::prefix('charge-request')->group(function () {

        Route::get('index', [WalletChargeController::class, 'index']);
    });
});
