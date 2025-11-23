<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\PatientController;

Route::middleware('admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::redirect('/', '/admin/dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::prefix('patients')
            ->name('patients.')
            ->group(function () {
                Route::get('/', [PatientController::class, 'index'])->name('index');
        });

        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/reports', [DashboardController::class, 'index'])->name('reports.index');
});