<?php

use App\Http\Controllers;
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
// Route::prefix('/stories')->group(function () {
//     Route::get('', [Controllers\StoryController::class, 'index']);
//     Route::get('/{id}', [Controllers\StoryController::class, 'show']);
// });
Route::resource('stories', Controllers\StoryController::class);
Route::resource('chapters', Controllers\ChapterController::class);
Route::resource('genres', Controllers\GenreController::class);

// Get Chapter List
Route::get('/stories/{story_id}/chapter-list', Controllers\ChapterListController::class);

// Authenticated ============================================================
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', Controllers\LoggedInController::class);
    Route::put('/user', Controllers\UpdateAccountDetailsController::class);
    Route::put('/user/password', Controllers\UpdatePasswordController::class);

    // My-Stories ==============================================================
    Route::get('/my-stories', [Controllers\MyStory\StoryController::class, 'index']);
    Route::post('/my-stories', [Controllers\MyStory\StoryController::class, 'store']);
    Route::get('/my-stories/{id}', [Controllers\MyStory\StoryController::class, 'show']);
    Route::put('/my-stories/{id}', [Controllers\MyStory\StoryController::class, 'update']);
    
    // My Chapters =============================================================
    Route::get('/my-chapters/{id}', [Controllers\MyStory\ChapterController::class, 'index']);
    Route::post('/my-chapters', [Controllers\MyStory\ChapterController::class, 'store']);
    Route::put('/my-chapters/{id}', [Controllers\MyStory\ChapterController::class, 'update']);
});