<?php

use App\Http\Controllers\Mobile\OrderController;
use Illuminate\Support\Facades\Route;



Route::prefix('mobile/order')->middleware('auth:sanctum','type.mobile')->group(function (){

    Route::get('index',[OrderController::class,'index']);
    Route::get('show/{id}',[OrderController::class,'show']);
    Route::post('update/{id}',[OrderController::class,'update']);
    Route::delete('cancel/{id}',[OrderController::class,'cancel']);
});