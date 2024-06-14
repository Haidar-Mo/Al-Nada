<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** MOBILE ROUTE FILES */
include __DIR__ . '/V1/Mobile/auth.php';
include __DIR__ . '/V1/Mobile/volunteering.php';
include __DIR__ . '/V1/Mobile/campaign.php';
include __DIR__ . '/V1/Mobile/news.php';
include __DIR__ . '/V1/Mobile/donation.php';

/** WEB ROUTE FILES */
include __DIR__ . '/V1/Web/administration.php';
include __DIR__ . '/V1/Web/employee.php';
include __DIR__ . '/V1/Web/section.php';
include __DIR__ . '/V1/Web/campaign.php';
