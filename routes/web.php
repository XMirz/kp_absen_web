<?php

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\PresenceController;
use App\Http\Controllers\Admin\PrintReportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return redirect(route('login'));
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});


Route::group(['middleware' => ['auth', 'role:dev|admin|chief']], function () {
  Route::get('/presences/print', [PrintReportController::class, 'show']); //Accept year and month parameter
  Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
  })->name('dashboard');
  Route::resource('/staffs', StaffController::class)->names('staffs');
  Route::resource('/presences', PresenceController::class)->names('presences');
  Route::group(['prefix' => '/settings'],  function () {
    Route::get('/', [SettingController::class, 'index'])->name('settings.index');
  });
});
require __DIR__ . '/auth.php';
