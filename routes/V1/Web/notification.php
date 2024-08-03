<?php

use App\Http\Controllers\Web\NotificationController;
use Illuminate\Support\Facades\Route;



Route::prefix('web/notification')->middleware([
    'auth:sanctum',
    'type.web'
])->group(function () {

    Route::get('index', [NotificationController::class, 'index']);
    Route::post('mark-as-read/{id}', [NotificationController::class, 'markAsRead']);
    Route::post('mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
    Route::post('send-notification', [NotificationController::class, 'notifyUser']);
});
