<?php

use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;


Route::get('/', fn () => null);

// Login/Logout =======================================================
Route::post('/login', [Controllers\LoginController::class, 'store']);
Route::post('/logout', [Controllers\LoginController::class, 'destroy']);

// TODO: Register New Account =================================================
Route::prefix('/register')->group(function () {
    Route::post('', Controllers\Register\RegisterController::class);
    Route::post('/verification', Controllers\Register\VerificationController::class);
    Route::post('/verification/resend', Controllers\Register\ResendVerificationController::class);
});

// TODO: Email Verification =================================================
Route::get('/verification', Controllers\Register\VerificationController::class)->name('verification');

// TODO: Password Reset =====================================================
Route::post('/password/forgot', Controllers\Password\ForgotPasswordController::class);
Route::post('/password/reset', Controllers\Password\ResetPasswordController::class);


// TODO: Global Lookups =====================================================


// Authenticated ============================================================
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', Controllers\LoggedInController::class);
    Route::put('/user', Controllers\UpdateAccountDetailsController::class);
    Route::put('/user/password', Controllers\UpdatePasswordController::class);

    // Stories ==============================================================
    Route::get('/stories', [Controllers\StoryController::class, 'index']);
});