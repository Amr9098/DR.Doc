<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Modules\Clinic\Http\Controllers\ClinicController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('doctor-clinic', ClinicController::class);
