<?php

use App\Http\Controllers\Web\OrphanFamilyController;
use App\Http\Controllers\Web\SponsorshipDocumentController;
use App\Http\Controllers\Web\SponsorshipCaseController;
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
       
        Route::get('index/update-request',[SponsorshipDocumentController::class, 'indexUpdateRequest']);
        Route::get('show/update-request/{id}', [SponsorshipDocumentController::class, 'showUpdateRequest']); 
        Route::post('accept/update-request/{id}', [SponsorshipDocumentController::class,'acceptDocumentUpdate']);
        Route::post('reject/update-request/{id}', [SponsorshipDocumentController::class,'rejectDocumentUpdate']);

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
        Route::get('assistance/{id}', [OrphanFamilyController::class, 'getAssistanceProvided']);

        Route::post('create', [OrphanFamilyController::class, 'store']);
        Route::post('create/child/{id}', [OrphanFamilyController::class, 'addChild']);
        Route::post('create/statement/{id}', [OrphanFamilyController::class, 'addStatement']);
        Route::post('create/assistance/{id}', [OrphanFamilyController::class, 'addAssistance']);

        Route::post('make-visible/{id}', [OrphanFamilyController::class, 'makeFamilyVisible']);
        Route::post('make-invisible/{id}', [OrphanFamilyController::class, 'makeFamilyInvisible']);
        Route::post('update/{id}', [OrphanFamilyController::class, 'update']);
        Route::post('update/child/{id}', [OrphanFamilyController::class, 'updateChild']);
        Route::post('update/statement/{id}', [OrphanFamilyController::class, 'updateStatement']);


        Route::delete('delete/{id}', [OrphanFamilyController::class, 'destroy']);
        Route::delete('delete/child/{id}', [OrphanFamilyController::class, 'deleteChild']);
        Route::delete('delete/statement/{id}', [OrphanFamilyController::class, 'deleteStatement']);
        Route::delete('delete/assistance/{id}', [OrphanFamilyController::class, 'deleteAssistance']);
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
