<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UserProfileController;

Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::middleware('redirect.notpatient')->group(function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/services', [HomeController::class, 'services'])->name('services');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
});

Route::middleware(['auth', 'patient.complete'])->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile', [UserProfileController::class, 'profile'])->name('user.profile');
    Route::get('/settings', [UserProfileController::class, 'settings'])->name('user.settings');
    Route::get('/appointments', [UserProfileController::class, 'appointments'])->name('user.appointments');
    Route::get('/transactions', [UserProfileController::class, 'transactions'])->name('user.transactions');
    Route::get('/histories', [UserProfileController::class, 'histories'])->name('user.histories');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';