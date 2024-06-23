<?php

use App\Http\Controllers\Mobile\BillingHistoryController;
use App\Http\Controllers\Mobile\WalletController;
use Illuminate\Support\Facades\Route;

Route::prefix('mobile/wallet')->middleware('auth:sanctum')->group(function () {

    Route::get('show', [WalletController::class, 'show']);
    Route::post('deposit', [WalletController::class, 'deposit']);
    Route::get('billing-history', [WalletController::class, 'billingHistory']);
});
