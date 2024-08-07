<?php

use App\Http\Controllers\Web\NotificationController;
use App\Mail\ConfirmationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('al-nada');
});

Route::get('noti',[NotificationController::class,'notifyUser']);

