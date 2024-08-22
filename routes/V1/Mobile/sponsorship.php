<?php

use App\Http\Controllers\Mobile\OrphanFamilyController;
use App\Http\Controllers\Mobile\SponsorshipCaseController;
use App\Http\Controllers\Mobile\SponsorshipDocumentController;
use Illuminate\Support\Facades\Route;


Route::prefix('mobile/sponsorship')->middleware([
    'auth:sanctum',
    'type.mobile'
])->group(function () {

    Route::prefix('document')->group(function () {

        Route::get('show', [SponsorshipDocumentController::class, 'show']);
        Route::post('create', [SponsorshipDocumentController::class, 'store']);
        Route::post('update-request', [SponsorshipDocumentController::class, 'update']);

    });

    Route::prefix('case')->middleware('isSponsor')->group(function () {

        Route::get('index', [SponsorshipCaseController::class, 'index']);
        Route::get('show/{id}', [SponsorshipCaseController::class, 'show'])->name('mobile.case.show');
        Route::get('list-status/{case}', [SponsorshipCaseController::class, 'listStatusUpdate']);
        Route::get('last-status/{case}', [SponsorshipCaseController::class, 'lastStatusUpdate'])->name('mobile.case.status.show');

        Route::post('payment/{id}', [SponsorshipCaseController::class, 'payment']);
        Route::get('payment/last/{id}', [SponsorshipCaseController::class, 'lastYearPayment']);
    });

    Route::prefix('orphan-family')->group(function () {

        Route::get('index', [OrphanFamilyController::class, 'index']);
        Route::get('index-child', [OrphanFamilyController::class, 'childIndex']);
        Route::get('show/{id}', [OrphanFamilyController::class, 'show']);
        Route::get('show-child/{id}', [OrphanFamilyController::class, 'childShow']);
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
