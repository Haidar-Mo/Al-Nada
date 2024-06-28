<?php

use App\Http\Controllers\Mobile\NewsController;
use Illuminate\Support\Facades\Route;


Route::prefix('mobile/news')->middleware('auth:sanctum', 'type.mobile', 'isActive')->group(function () {

    Route::get('index', [NewsController::class, 'index']);
    Route::get('show/{id}', [NewsController::class, 'show']);
});
