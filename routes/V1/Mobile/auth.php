<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Mobile\AuthController;


Route::prefix('mobile/auth/')->group(function () {

     Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
    Route::post('activate/{id}', [AuthController::class, 'activateAccount']);
    Route::get('profile', [AuthController::class, 'profile'])->middleware(['auth:sanctum']);
});
