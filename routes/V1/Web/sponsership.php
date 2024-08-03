<?php

use App\Http\Controllers\Web\OrphanFamilyController;
use App\Http\Controllers\web\SponsershipDocumentController;
use App\Http\Controllers\web\SponsershipCaseController;
use Illuminate\Support\Facades\Route;



Route::prefix('web/sponsership')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::prefix('document')->group(function () {

        Route::get('index', [SponsershipDocumentController::class, 'index']);
        Route::get('show/{id}', [SponsershipDocumentController::class, 'show']);
        Route::post('activate/{id}', [SponsershipDocumentController::class, 'activate']);
        Route::post('deactivate/{id}', [SponsershipDocumentController::class, 'deactivate']);
        Route::delete('', [SponsershipDocumentController::class,]);
    });

    Route::prefix('case')->group(function () {

        Route::get('index', [SponsershipCaseController::class, 'index']);
        Route::get('show/{id}', [SponsershipCaseController::class, 'show']);
        Route::post('', [SponsershipCaseController::class, '']);
        Route::post('', []);
        Route::delete('', []);
    });

    Route::prefix('orphans-family')->group(function () {

        Route::get('index', [OrphanFamilyController::class, 'index']);
        Route::get('family/{id}', [OrphanFamilyController::class, 'show']);
        Route::get('children/{id}', [OrphanFamilyController::class, 'getFamilyChildren']);
        Route::get('statement/{id}', [OrphanFamilyController::class, 'getFamilyStatement']);
       
        Route::post('create', [OrphanFamilyController::class, 'store']);
        Route::post('add/child/{id}', [OrphanFamilyController::class, 'addChild']);
        Route::post('add/statement/{id}', [OrphanFamilyController::class, 'addStatement']);
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
