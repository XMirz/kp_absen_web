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

Route::group(['middleware' => 'auth:sanctum'], function () {
  Route::post('/presence', [ApiPresenceController::class, 'store']);
  Route::patch('/presence/{presence}', [ApiPresenceController::class, 'update']);
  Route::get('/user', [AuthenticationController::class, 'index']);
  Route::get('/configdata', [ApiConfigurationController::class, 'index']);
});
Route::post('/sanctum/token', [AuthenticationController::class, 'store']);
