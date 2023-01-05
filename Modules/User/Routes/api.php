<?php

use App\Http\Middleware\CheckSuspended;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;
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

Route::post('login', [UserController::class,'login'])->withoutMiddleware([CheckSuspended::class]);
Route::get('logout', [UserController::class,'logout']);
Route::get('me', [UserController::class,'me']);
