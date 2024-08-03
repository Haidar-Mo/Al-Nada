<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ReportController;

Route::prefix('web/report')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {
    Route::get('index', [ReportController::class, 'index']);
    Route::get('show/{id}', [ReportController::class, 'show']);
    Route::delete('delete/{id}', [ReportController::class, 'destroy']);
});
