<?php

use App\Http\Controllers\Web\VolunteeringController;
use Illuminate\Support\Facades\Route;

Route::prefix('web/volunteer')->middleware('auth:sanctum', 'type.web')->group(function () {

    Route::get('index', [VolunteeringController::class, 'index']);
    Route::get('show/{id}', [VolunteeringController::class, 'show']);
    Route::put('accept/{id}', [VolunteeringController::class, 'accept']);
    Route::put('reject/{id}', [VolunteeringController::class, 'reject']);
    Route::post('', [VolunteeringController::class, '']);
});
