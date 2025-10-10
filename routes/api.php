<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZakatPaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and are assigned the "api"
| middleware group. Enjoy building your API!
|
*/

Route::post('/midtrans/notification', [ZakatPaymentController::class, 'handleNotification'])
    ->name('midtrans.notification');

Route::post('/midtrans/callback', [ZakatPaymentController::class, 'midtransCallback'])
    ->name('midtrans.callback');
