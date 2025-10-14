<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('v1')->group(function() {
        Route::get('/version', function() {
            return response()->json(['version' => '1.0.0'], Response::HTTP_OK);
        });
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::apiResource('appointments', AppointmentController::class);

        Route::prefix('admin')->name('admin.')->group(function() {
            Route::apiResource('dashboard', AppointmentController::class);
        });
    });
});