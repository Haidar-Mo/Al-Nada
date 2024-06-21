<?php

use App\Http\Controllers\Mobile\BillingHistoryController;
use App\Http\Controllers\Mobile\WalletController;
use Illuminate\Support\Facades\Route;

Route::prefix('mobile/wallet')->middleware('auth:sanctum')->group(function () {

    Route::get('billing-hoistory/index', [BillingHistoryController::class, 'index']);
    Route::get('show', [WalletController::class, 'show']);
});
