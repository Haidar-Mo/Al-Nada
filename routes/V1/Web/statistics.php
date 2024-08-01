<?php

use App\Http\Controllers\Web\StatisticsController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/statistics')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('employee', [StatisticsController::class, 'employee']);
    Route::get('volunteer', [StatisticsController::class, 'volunteer']);

    Route::get('campaign', [StatisticsController::class, 'campaign']);

    Route::get('financial-donations', [StatisticsController::class, 'financialDonations']);
    Route::get('inKind-donations', [StatisticsController::class, 'inKindDonations']);
});
