<?php

use App\Http\Controllers\Mobile\DonationController;
use Illuminate\Support\Facades\Route;

Route::prefix('mobile/donation')->middleware('auth:sanctum')->group(function () {

    Route::get('index', [DonationController::class, 'index']);
    Route::get('show/{id}', [DonationController::class, 'show']);
    Route::post('store', [DonationController::class, 'store']);
});
