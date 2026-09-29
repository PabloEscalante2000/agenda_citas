<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SesionController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',[LoginController::class, 'logout']);
    Route::get('/me',[LoginController::class, 'me']);

    // *  Solo administradores
    Route::middleware('can:admin')->group(function () {
        Route::apiResource('patients', PatientController::class);
    });

    Route::apiResource('sesions', SesionController::class);
});