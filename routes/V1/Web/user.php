<?php

use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('web/mobile-user')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [UserController::class, 'index']);
    Route::get('show/{id}', [UserController::class, 'show']);
    Route::post('ban/{id}', [UserController::class, 'ban']);
    Route::post('activate/{id}', [UserController::class, 'activate']);
});
