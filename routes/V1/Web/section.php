<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\SectionController;


Route::prefix('web/section')->group(function () {

    Route::get('index', [SectionController::class, 'index']);
    Route::get('show/{id}', [SectionController::class, 'show']);
    Route::post('create', [SectionController::class, 'store']);
    Route::put('update/{id}', [SectionController::class, 'update']);
    Route::delete('delete/{id}', [SectionController::class, 'destroy']);
});
