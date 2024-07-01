<?php

use App\Http\Controllers\Web\DonationController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/donation')->middleware(['auth:sanctum', 'type.web'])->group(function () {
    Route::get('index', [DonationController::class, 'index']);
    Route::get('show/{id}', [DonationController::class, 'show']);
    Route::post('accept/{id}', [DonationController::class, 'accept']);
    Route::post('reject/{id}', [DonationController::class, 'reject']);
});
