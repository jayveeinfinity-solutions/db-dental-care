<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('/', function() {
            return redirect()->route('admin.dashboard.index');
        });
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    });
// });