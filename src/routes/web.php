<?php

use Illuminate\Support\Facades\Route;
use BladeSync\Laraauth\Http\Controllers\AuthController;

// --- GUEST ROUTES ---
Route::middleware(['web', 'guest'])->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendOtp'])->name('password.email');

    Route::get('verify-otp', [AuthController::class, 'showOtpForm'])->name('otp.verify');
    Route::post('verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.check');

    Route::get('reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
});


// --- AUTHENTICATED ROUTES ---
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/home', function () {
        if (view()->exists('home')) {
            return view('home');
        }
        return view('authpkg::dashboard.home');
    })->name('home');
});