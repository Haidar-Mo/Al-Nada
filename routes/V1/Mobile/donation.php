<?php

use App\Http\Controllers\Mobile\DonationController;
use App\Http\Controllers\Mobile\DonationAlertController;

use App\Http\Controllers\Mobile\DonationCampaignController;
use App\Http\Controllers\Mobile\DonationCampaignAlertController;

use Illuminate\Support\Facades\Route;

Route::prefix('mobile/donation')->middleware('auth:sanctum')->group(function () {

    Route::get('index', [DonationController::class, 'index']);
    Route::get('show/{id}', [DonationController::class, 'show']);
    Route::post('create', [DonationController::class, 'store']);
});

Route::prefix('mobile/donation/campaign')->middleware('auth:sanctum')->group(function () {

    Route::get('index', [DonationCampaignController::class, 'index']);
    Route::get('show/{id}', [DonationCampaignController::class, 'show']);
    Route::post('create/{id}', [DonationCampaignController::class, 'store']);
});


Route::prefix('mobile/donation/alert')->middleware('auth:sanctum')->group(function () {

    Route::get('index', [DonationAlertController::class, 'index']);
    Route::get('show/{id}', [DonationAlertController::class, 'show']);
    Route::post('create', [DonationAlertController::class, 'store']);
    Route::post('update/{id}', [DonationAlertController::class, 'update']);
    Route::delete('delete/{id}', [DonationAlertController::class, 'destroy']);
});

Route::prefix('mobile/donation/campaign/alert')->middleware('auth:sanctum')->group(function () {

    Route::get('index', [DonationCampaignAlertController::class, 'index']);
    Route::get('show/{id}', [DonationCampaignAlertController::class, 'show']);
    Route::post('create/{id}', [DonationCampaignAlertController::class, 'store']);
    Route::post('update/{id}', [DonationCampaignAlertController::class, 'update']);
    Route::delete('delete/{id}', [DonationCampaignAlertController::class, 'destroy']);
});