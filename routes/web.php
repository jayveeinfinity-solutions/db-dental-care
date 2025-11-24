<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');

    Route::get('/appointments', [UserProfileController::class, 'appointments'])->name('appointments');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';