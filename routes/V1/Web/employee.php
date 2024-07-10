<?php

use App\Http\Controllers\Web\AdministrationController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\EvaluationController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/employee')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [EmployeeController::class, 'index']);
    Route::get('show/{id}', [EmployeeController::class, 'show']);
    Route::post('create', [EmployeeController::class, 'store']);
    Route::post('update/{id}', [EmployeeController::class, 'update']);
    Route::delete('delete/{id}', [EmployeeController::class, 'destroy']);

    Route::prefix('account')->group(function () {

        Route::get('index', [AdministrationController::class, 'index']);
        Route::get('show/{id}', [AdministrationController::class, 'show']);
        Route::post('create/{id}', [AdministrationController::class, 'store']);
        Route::post('update/user-name/{id}', [AdministrationController::class, 'updateUserName']);
        Route::post('update/password/{id}', [AdministrationController::class, 'updatePassword']);
        Route::post('update/role/{id}', [AdministrationController::class, 'updateRole']);
        Route::delete('delete/{id}', [AdministrationController::class, 'destroy']);
    });

    Route::prefix('evaluation')->group(function () {

        Route::get('index', [EvaluationController::class, 'index']);
        Route::get('show/{id}', [EvaluationController::class, 'show']);
        Route::post('create/{id}', [EvaluationController::class, 'store']);
        Route::post('update/{id}', [EvaluationController::class, 'update']);
        Route::delete('delete/{id}', [EvaluationController::class, 'destroy']);
    });
});
