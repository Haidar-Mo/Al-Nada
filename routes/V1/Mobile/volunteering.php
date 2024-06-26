<?php

use App\Http\Controllers\Mobile\VolunteeringController;
use App\Http\Controllers\Mobile\VolunteeringInCampaignController;
use Illuminate\Support\Facades\Route;

Route::prefix('mobile/volunteering/demand')->middleware('auth:sanctum', 'type.mobile')->group(function () {

    Route::get('index', [VolunteeringController::class, 'index']);
    Route::get('show/{id}', [VolunteeringController::class, 'show']);
    Route::post('create', [VolunteeringController::class, 'store']);
    Route::post('update/{id}', [VolunteeringController::class, 'update']);
    Route::delete('cancel/{id}', [VolunteeringController::class, 'destroy']);
    //Route::delete('cancel', [VolunteeringController::class, 'destroy']); => زر الغاء طلب التطوع لا علاقة له بطلب التطوع
});

Route::prefix('mobile/volunteering/campaign/demand')->middleware(['auth:sanctum', 'type.mobile'])->group(function () {

    Route::get('index', [VolunteeringInCampaignController::class, 'index']);
    Route::get('show/{id}', [VolunteeringInCampaignController::class, 'show']);
    Route::post('create/{id}', [VolunteeringInCampaignController::class, 'store']);
    Route::post('update/{id}', [VolunteeringInCampaignController::class, 'update']);
    Route::delete('cancel/{id}', [VolunteeringInCampaignController::class, 'destroy']);
});
