<?php

use App\Http\Controllers\Web\DonationController;
use App\Http\Controllers\Web\DonationToCampaignController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/donation')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {
    Route::get('index', [DonationController::class, 'index']);
    Route::get('show/{id}', [DonationController::class, 'show']);
    Route::post('accept/{id}', [DonationController::class, 'accept']);
    Route::post('reject/{id}', [DonationController::class, 'reject']);
});


Route::prefix('web/donation/campaign')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function (){
    Route::get('index', [DonationToCampaignController::class, 'index']);
    Route::get('show/{id}', [DonationToCampaignController::class, 'show']);
    Route::post('accept/{id}', [DonationToCampaignController::class, 'accept']);
    Route::post('reject/{id}', [DonationToCampaignController::class, 'reject']);
});
