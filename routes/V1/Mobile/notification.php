<?php

use App\Http\Controllers\Mobile\NotificationController;
use Illuminate\Support\Facades\Route;



Route::prefix('mobile/notification')->middleware('auth:sanctum', 'type.mobile')->group(function () {
    Route::get('index', [NotificationController::class, 'index']);
    Route::post('mark-as-read/{id}', [NotificationController::class, 'markAsRead']);
    Route::post('mark-as-unread/{id}', [NotificationController::class, 'MarkAsUnRead']);
    Route::post('mark-all-as-read', [NotificationController::class, 'MarkAllAsRead']);
    Route::delete('delete/{id}', [NotificationController::class, 'destroy']);
});
