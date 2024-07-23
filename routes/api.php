<?php

use App\Models\Administration;
use App\Models\User;
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

Route::get('a', function () {
    $user = Administration::find(1);
    $user->assignRole('admin');
    return $user;
});

/** MOBILE ROUTE FILES */
include __DIR__ . '/V1/Mobile/auth.php';
include __DIR__ . '/V1/Mobile/notification.php';
include __DIR__ . '/V1/Mobile/wallet.php';
include __DIR__ . '/V1/Mobile/donation.php';
include __DIR__ . '/V1/Mobile/volunteering.php';
include __DIR__ . '/V1/Mobile/campaign.php';
include __DIR__ . '/V1/Mobile/product.php';
include __DIR__ . '/V1/Mobile/order.php';
include __DIR__ . '/V1/Mobile/news.php';

/** WEB ROUTE FILES */
include __DIR__ . '/V1/Web/administration.php';
include __DIR__ . '/V1/Web/user.php';
include __DIR__ . '/V1/Web/employee.php';
include __DIR__ . '/V1/Web/section.php';
include __DIR__ . '/V1/Web/campaign.php';
include __DIR__ . '/V1/Web/donation.php';
include __DIR__ . '/V1/Web/volunteering.php';
include __DIR__ . '/V1/Web/product.php';
include __DIR__ . '/V1/Web/kitchen.php';
include __DIR__ . '/V1/Web/news.php';
include __DIR__ . '/V1/Web/wallet.php';
