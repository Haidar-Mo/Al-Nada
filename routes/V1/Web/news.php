<?php

use App\Http\Controllers\Web\NewsController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/news')->middleware('auth:sanctum')->group(function () {

    Route::get('index', [NewsController::class, 'index']);
    Route::get('show/{id}', [NewsController::class, 'show']);
    Route::post('create', [NewsController::class, 'store']);
    Route::post('update/{id}', [NewsController::class, 'update']);
    Route::delete('delete-image/{id}', [NewsController::class, 'deleteImage']);
    Route::delete('delete/{id}', [NewsController::class, 'destroy']);
});
