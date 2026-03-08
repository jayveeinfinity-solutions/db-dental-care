<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/general-dentistry', [StaticPagesController::class, 'generalDentistry'])->name('static.general-dentistry');
Route::get('/cosmetic-dentistry', [StaticPagesController::class, 'cosmeticDentistry'])->name('static.cosmetic-dentistry');
Route::get('/restorative-dentistry', [StaticPagesController::class, 'restorativeDentistry'])->name('static.restorative-dentistry');
Route::get('/preventive-dentistry', [StaticPagesController::class, 'preventiveDentistry'])->name('static.preventive-dentistry');
Route::get('/orthodontics', [StaticPagesController::class, 'orthodontics'])->name('static.orthodontics');

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

    Route::get('/patient-history/{patientHistory}', [PatientHistoryController::class, 'view'])->name('patient.history.view');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';