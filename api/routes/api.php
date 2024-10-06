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
    Route::post('/verification/resend', [Controllers\Register\ResendVerificationController::class, 'store']);
});

// TODO: Email Verification =================================================
// Route::get('/verification', Controllers\Register\VerificationController::class)->name('verification');

// TODO: Password Reset =====================================================
Route::post('/password/forgot', Controllers\Password\ForgotPasswordController::class);
Route::post('/password/reset', Controllers\Password\ResetPasswordController::class);


// TODO: Global Lookups =====================================================
Route::prefix('/stories')->group(function () {
    Route::post('', [Controllers\StoryController::class, 'index']);
    Route::get('/{story}', [Controllers\StoryController::class, 'show']);
});
// Route::resource('stories', Controllers\StoryController::class);
Route::resource('chapters', Controllers\ChapterController::class);
Route::resource('genres', Controllers\GenreController::class);
Route::resource('ratings', Controllers\RatingController::class);

// Get Chapter List
Route::get('/stories/{story_id}/chapter-list', Controllers\ChapterListController::class);

// Applause
Route::post('/applause', [Controllers\ApplauseController::class, 'store']);

// Get all comments for a story
Route::get('/comments', [Controllers\CommentController::class, 'index']);
// Get single comment
Route::get('/comment/{comment}', [Controllers\CommentController::class, 'show']);

// Authenticated ============================================================
Route::middleware(['auth:sanctum', 'cors'])->group(function () {
    Route::get('/user', Controllers\LoggedInController::class);
    Route::put('/user', [Controllers\UpdateAccountDetailsController::class, 'update']);
    Route::put('/user/password', Controllers\UpdatePasswordController::class);
    // Email Verification
    Route::post('/auth/verification/resend', [Controllers\Register\ResendVerificationController::class, 'store']);

    // My-Stories ==============================================================
    Route::get('/my-stories', [Controllers\MyStory\StoryController::class, 'index']);
    Route::post('/my-stories', [Controllers\MyStory\StoryController::class, 'store']);
    Route::get('/my-stories/{id}', [Controllers\MyStory\StoryController::class, 'show']);
    Route::put('/my-stories/{id}', [Controllers\MyStory\StoryController::class, 'update']);
    
    // My Chapters =============================================================
    Route::get('/my-chapters/{id}', [Controllers\MyStory\ChapterController::class, 'index']);
    Route::post('/my-chapters', [Controllers\MyStory\ChapterController::class, 'store']);
    Route::put('/my-chapters/{id}', [Controllers\MyStory\ChapterController::class, 'update']);
    
    // My Bookmarks ============================================================
    Route::get('/my-bookmarks', [Controllers\BookmarkController::class, 'index']);
    Route::put('/my-bookmark/{bookmark}', [Controllers\BookmarkController::class, 'update']);
    Route::post('/my-bookmark', [Controllers\BookmarkController::class, 'store']);
    Route::delete('/my-bookmark/{bookmark}', [Controllers\BookmarkController::class, 'destroy']);
    
    // Comments ============================================================
    Route::post('/comment', [Controllers\CommentController::class, 'store']);
    Route::put('/comment/{comment}', [Controllers\CommentController::class, 'update']);
    Route::delete('/comment/{comment}', [Controllers\CommentController::class, 'destroy']);

});