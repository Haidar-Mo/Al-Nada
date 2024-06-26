<?php

use App\Http\Controllers\Web\AdministrationController;
use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/auth/')->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', 'type.web']);
    // Route::get('profile', [AuthController::class, 'profile'])->middleware(['auth:sanctum']);

    // Route::post('change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
    // Route::post('reset-password', [AuthController::class, 'autoResetPassword']);
});
