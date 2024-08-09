<?php

use App\Http\Controllers\Web\OrphanFamilyController;
use App\Http\Controllers\web\SponsorshipDocumentController;
use App\Http\Controllers\web\SponsorshipCaseController;
use Illuminate\Support\Facades\Route;



Route::prefix('web/sponsership')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::prefix('document')->group(function () {

        Route::get('index', [SponsorshipDocumentController::class, 'index']);
        Route::get('show/{id}', [SponsorshipDocumentController::class, 'show']);
        Route::post('activate/{id}', [SponsorshipDocumentController::class, 'activate']);
        Route::post('deactivate/{id}', [SponsorshipDocumentController::class, 'deactivate']);
        Route::delete('', [SponsorshipDocumentController::class,]);
    });

    Route::prefix('case')->group(function () {

        Route::get('index', [SponsorshipCaseController::class, 'index']);
        Route::get('show/{id}', [SponsorshipCaseController::class, 'show']);
        Route::post('accept/{id}', [SponsorshipCaseController::class, 'accept']);
        Route::post('reject/{id}', [SponsorshipCaseController::class, 'reject']);
        Route::delete('stop/{id}', [SponsorshipCaseController::class, 'stop']);
    });

    Route::prefix('orphan-family')->group(function () {

        Route::get('index', [OrphanFamilyController::class, 'index']);
        Route::get('family/{id}', [OrphanFamilyController::class, 'show']);
        Route::get('children/{id}', [OrphanFamilyController::class, 'getFamilyChildren']);
        Route::get('statement/{id}', [OrphanFamilyController::class, 'getFamilyStatement']);

        Route::post('create', [OrphanFamilyController::class, 'store']);
        Route::post('add/child/{id}', [OrphanFamilyController::class, 'addChild']);
        Route::post('add/statement/{id}', [OrphanFamilyController::class, 'addStatement']);
        Route::post('add/status-update/{id}', [OrphanFamilyController::class, 'addStatusUpdate']);

        Route::post('make-visible/{id}', [OrphanFamilyController::class, 'makeFamilyVisible']);
        Route::post('make-invisible/{id}', [OrphanFamilyController::class, 'makeFamilyInvisible']);
        Route::post('update/{id}', [OrphanFamilyController::class, 'update']);
        Route::post('child/update/{id}', [OrphanFamilyController::class, 'updateChild']);
        Route::post('statement/update/{id}', [OrphanFamilyController::class, 'updateStatement']);
        Route::post('status-update/update/{id}', [OrphanFamilyController::class, 'updateStatusUpdate']);


        Route::delete('delete/{id}', [OrphanFamilyController::class, 'destroy']);
        Route::delete('child/delete/{id}', [OrphanFamilyController::class, 'deleteChild']);
        Route::delete('statement/delete/{id}', [OrphanFamilyController::class, 'deleteStatement']);
        Route::delete('status-update/delete/{id}', [OrphanFamilyController::class, 'deleteStatusUpdate']);
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
