<?php

use App\Http\Controllers\mobile\SponsershipDocumentController;
use Illuminate\Support\Facades\Route;


Route::prefix('mobile/sponsership')->middleware([
    'auth:sanctum',
    'type.mobile'
])->group(function () {

    Route::prefix('document')->group(function () {

        Route::get('', [SponsershipDocumentController::class,]);
        Route::get('show', [SponsershipDocumentController::class, 'show']);
        Route::post('create', [SponsershipDocumentController::class, 'store']);
        Route::post('', [SponsershipDocumentController::class,]);
        Route::delete('', [SponsershipDocumentController::class,]);
    });

    Route::prefix('')->group(function () {

        Route::get('', []);
        Route::get('', []);
        Route::post('', []);
        Route::post('', []);
        Route::delete('', []);
    });

    Route::prefix('')->group(function () {

        Route::get('', []);
        Route::get('', []);
        Route::post('', []);
        Route::post('', []);
        Route::delete('', []);
    });

    Route::prefix('')->group(function () {

        Route::get('', []);
        Route::get('', []);
        Route::post('', []);
        Route::post('', []);
        Route::delete('', []);
    });
});
