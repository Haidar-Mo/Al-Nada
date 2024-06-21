<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CampaignController;

Route::prefix('web/campaign')->group(function () {
    Route::get('index', [CampaignController::class, 'index']);
    Route::get('show/{id}', [CampaignController::class, 'show']);
    Route::post('create', [CampaignController::class, 'store']);
    Route::put('update/{id}', [CampaignController::class, 'update']);
    Route::delete('delete/{id}', [CampaignController::class, 'destroy']);
});
