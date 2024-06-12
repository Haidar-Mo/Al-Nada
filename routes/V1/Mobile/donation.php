<?php

use App\Http\Controllers\Mobile\DonationAlertController;
use App\Http\Controllers\Mobile\DonationController;
use Illuminate\Support\Facades\Route;

Route::prefix('mobile/donation')->middleware('auth:sanctum')->group(function () {

    Route::get('index', [DonationController::class, 'index']);
    Route::get('show/{id}', [DonationController::class, 'show']);
    Route::post('store', [DonationController::class, 'store']);
});

Route::prefix('mobile/donation/alert')->middleware('auth:sanctum')->group(function () {

    Route::get('index', [DonationAlertController::class, 'index']);
    Route::get('show/{id}', [DonationAlertController::class, 'show']);
    Route::post('create', [DonationAlertController::class, 'store']);
    Route::post('update/{id}', [DonationAlertController::class, 'update']);
    Route::delete('delete/{id}', [DonationAlertController::class, 'destroy']);
});
