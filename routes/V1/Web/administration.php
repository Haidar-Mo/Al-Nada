<?php

use App\Http\Controllers\Web\AdministrationController;
use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/auth/')->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
    // Route::get('profile', [AuthController::class, 'profile'])->middleware(['auth:sanctum']);

    // Route::post('change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
    // Route::post('reset-password', [AuthController::class, 'autoResetPassword']);
});

Route::prefix('web/management/account')->middleware('auth:sanctum')->group(function () {

    Route::get('index', [AdministrationController::class, 'index']);
    Route::get('show/{id}', [AdministrationController::class, 'show']);
    Route::post('create/{id}', [AdministrationController::class, 'store']);
    Route::post('update/user-name/{id}', [AdministrationController::class, 'updateUserName']);
    Route::post('update/password/{id}', [AdministrationController::class, 'updatePassword']);
    Route::post('update/role/{id}', [AdministrationController::class, 'updateRole']);
    Route::delete('delete/{id}', [AdministrationController::class, 'destroy']);
});
