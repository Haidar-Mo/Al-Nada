<?php

use App\Http\Controllers\Web\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::prefix('web/employee')->group(function () {


    Route::get('index', [EmployeeController::class, 'index']);
    Route::get('show/{id}', [EmployeeController::class, 'show']);
    Route::post('create', [EmployeeController::class, 'store']);
    Route::post('update/{id}', [EmployeeController::class, 'update']);
    Route::delete('delete/{id}', [EmployeeController::class, 'destroy']);
});
