<?php

use App\Http\Controllers\Web\SuccessStoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/story')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [SuccessStoryController::class, 'index']);
    Route::get('show/{id}', [SuccessStoryController::class, 'show']);
    Route::post('create', [SuccessStoryController::class, 'store']);
    Route::post('update/{id}', [SuccessStoryController::class, 'update']);
    Route::delete('delete/{id}', [SuccessStoryController::class, 'destroy']);
});
