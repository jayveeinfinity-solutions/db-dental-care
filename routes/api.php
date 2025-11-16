<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\AppointmentController;

Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('v1')->name('api.')->group(function() {
        Route::get('/version', function() {
            return response()->json(['version' => '1.0.0'], Response::HTTP_OK);
        });
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::apiResource('appointments', AppointmentController::class);
        Route::patch('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel']);
        Route::put('appointments/{appointment}/status', [AppointmentController::class, 'updateStatus']);

        Route::get('services/search', [ServiceController::class, 'search']);

        Route::prefix('admin')->name('admin.')->group(function() {
            Route::apiResource('dashboard', AppointmentController::class);
        });
    });
});