<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Doctor\Http\Controllers\AuthDoctorController;
use Modules\Doctor\Http\Controllers\DoctorAssistantController;
use Modules\Doctor\Http\Controllers\DoctorController;

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
Route::post('register-doctor', [DoctorController::class,'store'])->withoutMiddleware([CheckSuspended::class]);
Route::post('doctor-image', [DoctorController::class,'UpdateAuthDoctorImage']);

Route::get('doctor-profile', [AuthDoctorController::class,'AuthDoctorProfile']);
Route::post('update-doctor-profile', [AuthDoctorController::class,'AuthDoctorUpdateProfile']);

Route::apiResource('doctor', DoctorController::class);
Route::apiResource('doctor-assistant', DoctorAssistantController::class);
