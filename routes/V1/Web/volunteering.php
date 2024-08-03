<?php

use App\Http\Controllers\Web\VolunteerController;
use App\Http\Controllers\Web\VolunteerInCampaignController;
use App\Http\Controllers\Web\VolunteeringRequestController;
use App\Http\Controllers\Web\VolunteeringInCampaignRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('web/volunteering/request')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [VolunteeringRequestController::class, 'index']);
    Route::get('show/{id}', [VolunteeringRequestController::class, 'show']);
    Route::post('accept/{id}', [VolunteeringRequestController::class, 'accept']);
    Route::post('reject/{id}', [VolunteeringRequestController::class, 'reject']);
    Route::post('delete/{id}', [VolunteeringRequestController::class, 'destroy']);
});

Route::prefix('web/volunteering/person')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [VolunteerController::class, 'index']);
    Route::get('show/{id}', [VolunteerController::class, 'show']);
    Route::post('create', [VolunteerController::class, 'store']);
    Route::post('update/{id}', [VolunteerController::class, 'update']);
    Route::post('activate/{id}', [VolunteerController::class, 'activate']);
    Route::post('deactivate/{id}', [VolunteerController::class, 'deactivate']);
    Route::post('rate/{id}', [VolunteerController::class, 'rate']);
    Route::delete('delete/{id}', [VolunteerController::class, 'destroy']);
});




Route::prefix('web/volunteering/campaign/request')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [VolunteeringInCampaignRequestController::class, 'index']);
    Route::get('show/{id}', [VolunteeringInCampaignRequestController::class, 'show']);
    Route::post('accept/{id}', [VolunteeringInCampaignRequestController::class, 'accept']);
    Route::post('reject/{id}', [VolunteeringInCampaignRequestController::class, 'reject']);
    Route::post('delete/{id}', [VolunteeringInCampaignRequestController::class, 'destory']);
});

Route::prefix('web/volunteering/campaign/person')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [VolunteerInCampaignController::class, 'index']);
    Route::get('show/{id}', [VolunteerInCampaignController::class, 'show']);
    Route::post('create', [VolunteerInCampaignController::class, 'store']);
    Route::post('update/{id}', [VolunteerInCampaignController::class, 'update']);
    Route::post('activate/{id}', [VolunteerInCampaignController::class, 'activate']);
    Route::post('deactivate/{id}', [VolunteerInCampaignController::class, 'deactivate']);
    Route::delete('delete/{id}', [VolunteerInCampaignController::class, 'destroy']);
});