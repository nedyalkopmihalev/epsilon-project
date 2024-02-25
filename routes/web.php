<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Network\NetworkController;
use App\Http\Controllers\Services\ServicesController;
use App\Http\Controllers\Ports\PortsController;

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

Route::get('/', [NetworkController::class, 'index']);
Route::get('/service/{serviceId}', [ServicesController::class, 'getService']);
Route::get('/ports', [PortsController::class, 'getAllPorts']);
