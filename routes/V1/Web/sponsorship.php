<?php

use App\Http\Controllers\Web\OrphanFamilyController;
use App\Http\Controllers\web\SponsorshipDocumentController;
use App\Http\Controllers\web\SponsorshipCaseController;
use Illuminate\Support\Facades\Route;



Route::prefix('web/sponsorship')->middleware([
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
        Route::post('end/{id}', [SponsorshipCaseController::class, 'end']);
    
        Route::get('status-update/index/{id}', [SponsorshipCaseController::class, 'indexStatusUpdate']);
        Route::post('status-update/add/{id}', [SponsorshipCaseController::class, 'addStatusUpdate']);
        Route::post('status-update/update/{id}', [SponsorshipCaseController::class, 'updateStatusUpdate']);
        Route::delete('status-update/delete/{id}', [SponsorshipCaseController::class, 'destroyStatusUpdate']);
    
    });

    Route::prefix('orphan-family')->group(function () {

        Route::get('index', [OrphanFamilyController::class, 'index']);
        Route::get('family/{id}', [OrphanFamilyController::class, 'show']);
        Route::get('children/{id}', [OrphanFamilyController::class, 'getFamilyChildren']);
        Route::get('statement/{id}', [OrphanFamilyController::class, 'getFamilyStatement']);

        Route::post('create', [OrphanFamilyController::class, 'store']);
        Route::post('add/child/{id}', [OrphanFamilyController::class, 'addChild']);
        Route::post('add/statement/{id}', [OrphanFamilyController::class, 'addStatement']);

        Route::post('make-visible/{id}', [OrphanFamilyController::class, 'makeFamilyVisible']);
        Route::post('make-invisible/{id}', [OrphanFamilyController::class, 'makeFamilyInvisible']);
        Route::post('update/{id}', [OrphanFamilyController::class, 'update']);
        Route::post('child/update/{id}', [OrphanFamilyController::class, 'updateChild']);
        Route::post('statement/update/{id}', [OrphanFamilyController::class, 'updateStatement']);


        Route::delete('delete/{id}', [OrphanFamilyController::class, 'destroy']);
        Route::delete('child/delete/{id}', [OrphanFamilyController::class, 'deleteChild']);
        Route::delete('statement/delete/{id}', [OrphanFamilyController::class, 'deleteStatement']);
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
