<?php

use App\Http\Controllers\Mobile\WalletFatoraController;
use App\Http\Controllers\Mobile\WalletController;
use Illuminate\Support\Facades\Route;

Route::prefix('mobile/wallet')->middleware([
    'auth:sanctum',
    'type.mobile',
    'isActive'
])->group(function () {

    Route::get('show', [WalletController::class, 'show']);
    Route::get('billing-history', [WalletController::class, 'billingHistory'])->name('billing-history');
    Route::post('deposit', [WalletController::class, 'deposit']);
    Route::get('charge/index', [WalletController::class, 'listChargeRequests']);
    Route::get('charge/show/{id}', [WalletController::class, 'showChargeRequest'])->name('mobile.charge.show');

    Route::prefix('fatora')->group(function () {

        Route::post('charge', [WalletFatoraController::class, 'createPayment'])->name('fatora-payment');
        
        Route::get('get-payment-status/{id}', [WalletFatoraController::class, 'paymentStatus'])->name('fatora-payment-status');
        Route::get('payment-trigger', [WalletFatoraController::class, 'handlePaymentTrigger'])->name('fatora-payment-trigger');
        Route::get('payment-callback', [WalletFatoraController::class, 'handlePaymentCallback'])->name('fatora-payment-callback');
    });
});
