<?php

use App\Http\Controllers\Api\ApiConfigurationController;
use App\Http\Controllers\Api\ApiPresenceController;
use App\Http\Controllers\Api\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/presence', [ApiPresenceController::class, 'index']);
Route::group(['middleware' => 'auth:sanctum'], function () {
  Route::post('/presence', [ApiPresenceController::class, 'store']);
  Route::patch('/presence/{presence}', [ApiPresenceController::class, 'update']);
  Route::get('/user', [AuthenticationController::class, 'index']);
  Route::patch('/user/password', [AuthenticationController::class, 'update']);
  Route::get('/configdata', [ApiConfigurationController::class, 'index']);
  Route::delete('/sanctum', [AuthenticationController::class, 'destroy']);
});
Route::post('/sanctum/token', [AuthenticationController::class, 'store']);
