<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TransactionController;

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

        Route::get('/patient', function (Request $request) {
            return $request->user()?->patient ?? [];
        });
        Route::post('patients', [PatientController::class, 'store'])->name('patient.store');
        Route::put('patients/{id}', [PatientController::class, 'update'])->name('patient.update');
        Route::post('patients/link', [PatientController::class, 'link'])->name('patient.link');

        Route::get('patients/search', [PatientController::class, 'search']);
        Route::get('services/search', [ServiceController::class, 'search']);

        Route::post('transactions', [TransactionController::class, 'store'])->name('transaction.store');

        Route::prefix('admin')->name('admin.')->group(function() {
            Route::apiResource('dashboard', AppointmentController::class);
        });
    });
});