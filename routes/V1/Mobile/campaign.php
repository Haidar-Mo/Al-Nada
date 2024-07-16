<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Mobile\CampaignController;
use App\Http\Controllers\Mobile\FavoriteController;


Route::prefix('mobile/campaign')->middleware([
    'auth:sanctum',
    'isActive',
    'type.mobile'
])->group(function () {

    Route::get('index', [CampaignController::class, 'index']);
    Route::get('donateable', [CampaignController::class, 'donateableCampaign']);
    Route::get('volunteerable', [CampaignController::class, 'volunteerableCampaign']);
    Route::get('show/{id}', [CampaignController::class, 'show'])->name('mobile.show-campaign');

    Route::prefix('favorite')->group(function () {

        Route::get('index', [FavoriteController::class, 'index']);
        Route::post('create/{id}', [FavoriteController::class, 'store']);
        Route::delete('delete/{id}', [FavoriteController::class, 'destroy']);
    });
});
