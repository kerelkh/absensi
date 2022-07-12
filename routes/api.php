<?php

use App\Http\Controllers\Api\AbsenController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/getUser', [UserController::class, 'getUser']);
    Route::post('/absen/masuk', [AbsenController::class, 'absenMasuk']);
    Route::post('/absen/pulang', [AbsenController::class, 'absenPulang']);


    //get User data
    Route::get('/user/detail', [UserController::class, 'getUserDetail']);
    Route::get('/user/absentoday', [UserController::class, 'getAbsenToday']);
});
