<?php

use App\Http\Controllers\SensorDataController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sensor-monitor', [SensorDataController::class, 'showData']);
// API untuk mendapatkan data sensor
Route::get('/api/sensor-data', [SensorDataController::class, 'index']);
Route::get('/sensor-data', [SensorDataController::class, 'showData']);