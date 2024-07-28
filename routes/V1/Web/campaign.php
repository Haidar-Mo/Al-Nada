<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CampaignController;

Route::prefix('web/campaign')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {
    Route::get('index', [CampaignController::class, 'index']);
    Route::get('show/{id}', [CampaignController::class, 'show']);
    Route::post('create', [CampaignController::class, 'store']);
    Route::post('update/{id}', [CampaignController::class, 'update']);
    Route::delete('delete/{id}', [CampaignController::class, 'destroy']);

    Route::post('finish/{id}', [CampaignController::class, 'finish']);
    Route::get('volunteers/{id}', [CampaignController::class, 'getAllVolunteers']);
    Route::get('donors/{id}', [CampaignController::class, 'getAllDonors']);
});
