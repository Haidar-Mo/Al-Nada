<?php

use App\Http\Controllers\Web\VolunteerController;
use App\Http\Controllers\Web\VolunteeringController;
use App\Http\Controllers\Web\VolunteeringInCampaignController;
use Illuminate\Support\Facades\Route;

Route::prefix('web/volunteering/request')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [VolunteeringController::class, 'index']);
    Route::get('show/{id}', [VolunteeringController::class, 'show']);
    Route::post('accept/{id}', [VolunteeringController::class, 'accept']);
    Route::post('reject/{id}', [VolunteeringController::class, 'reject']);
    Route::post('delete/{id}', [VolunteeringController::class, 'destroy']);
});

Route::prefix('web/volunteering/person')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [VolunteerController::class, 'index']);
    Route::get('show/{id}', [VolunteerController::class, 'show']);
    Route::post('delete/{id}', [VolunteerController::class, 'destroy']);
});




Route::prefix('web/volunteering/campaign/request')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [VolunteeringInCampaignController::class, 'index']);
    Route::get('show/{id}', [VolunteeringInCampaignController::class, 'show']);
    Route::post('accept/{id}', [VolunteeringInCampaignController::class, 'accept']);
    Route::post('reject/{id}', [VolunteeringInCampaignController::class, 'reject']);
    Route::post('delete/{id}', [VolunteeringInCampaignController::class, 'destory']);
});
