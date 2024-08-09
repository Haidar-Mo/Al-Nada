<?php

use App\Http\Controllers\Mobile\WalletController;
use Illuminate\Support\Facades\Route;

Route::prefix('mobile/wallet')->middleware([
    'auth:sanctum',
    'type.mobile',
    'isActive'
])->group(function () {

    Route::get('show', [WalletController::class, 'show']);
    Route::post('deposit', [WalletController::class, 'deposit']);
    Route::get('billing-history', [WalletController::class, 'billingHistory'])->name('billing-history');
    Route::get('charge/index', [WalletController::class, 'listChargeRequests']);
    Route::get('charge/show/{id}', [WalletController::class, 'showChargeRequest'])->name('mobile.charge.show');
});
