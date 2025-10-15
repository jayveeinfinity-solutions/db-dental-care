<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware('admin')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('/', function() {
            return redirect()->route('admin.dashboard.index');
        });
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    });
});