<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;


Route::get('/', fn () => null);

// Login/Logout =======================================================
Route::post('/login', [Controllers\LoginController::class, 'store']);
Route::post('/logout', [Controllers\LoginController::class, 'destroy']);

// TODO: Email Verification =================================================


// TODO: Password Reset =====================================================


// TODO: Global Lookups =====================================================


// Authenticated ============================================================
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', Controllers\LoggedInController::class);
});