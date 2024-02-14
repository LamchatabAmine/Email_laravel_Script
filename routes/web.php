<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EmailStatisticsController;
use App\Http\Controllers\SmtpController;

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

Route::get('/', [EmailStatisticsController::class, 'index']);



Route::get('/send-emails', [EmailController::class, 'sendEmails']);
Route::get('/test', [EmailController::class, 'test']);



Route::post('/add-smtp', [SmtpController::class, 'addSmtp']);
Route::post('/import-email-addresses', [EmailController::class, 'importEmailAddresses']);
