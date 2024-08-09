<?php

use App\Http\Controllers\Mobile\OrphanFamilyController;
use App\Http\Controllers\Mobile\SponsorshipCaseController;
use App\Http\Controllers\mobile\SponsorshipDocumentController;
use Illuminate\Support\Facades\Route;


Route::prefix('mobile/sponsership')->middleware([
    'auth:sanctum',
    'type.mobile'
])->group(function () {

    Route::prefix('document')->group(function () {

        Route::get('show/{id}', [SponsorshipDocumentController::class, 'show']);
        Route::post('create', [SponsorshipDocumentController::class, 'store']);
        Route::post('update', [SponsorshipDocumentController::class, 'update']);
    });

    Route::prefix('case')->middleware('isSponsor')->group(function () {

        Route::get('index', [SponsorshipCaseController::class, 'index']);
        Route::get('show/{id}', [SponsorshipCaseController::class, 'show'])->name('mobile.case.show');
        Route::get('list-status/{id}', [SponsorshipCaseController::class, 'listStatusUpdate']);
        Route::get('last-status/{id}', [SponsorshipCaseController::class, 'lastStatusUpdate'])->name('mobile.case.status.show');
    });

    Route::prefix('orphan-family')->group(function () {

        Route::get('index', [OrphanFamilyController::class, 'index']);
        Route::get('show/{id}', [OrphanFamilyController::class, 'show']);
        Route::post('create-case/{id}', [OrphanFamilyController::class, 'createSponsorshipCase'])->middleware('isSponsor');
        Route::post('', []);
        Route::delete('', []);
    });

    Route::prefix('')->middleware('isSponser')->group(function () {

        Route::get('', []);
        Route::get('', []);
        Route::post('', []);
        Route::post('', []);
        Route::delete('', []);
    });
});
