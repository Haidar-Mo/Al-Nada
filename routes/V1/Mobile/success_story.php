<?php

use App\Http\Controllers\Mobile\SuccessStoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('mobile/story')->middleware([
    'auth:sanctum',
    'type.mobile'
])->group(function () {

    // Route::get('index', [SuccessStoryController::class, 'index']);

    Route::get('lady', [SuccessStoryController::class, 'getLadyStory']);
    Route::get('student', [SuccessStoryController::class, 'getStudentStory']);
    Route::get('show/{id}', [SuccessStoryController::class, 'show']);
});
