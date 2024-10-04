<?php

namespace App\Http\Controllers\Register;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\VerifyEmail;

class ResendVerificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User */
        $user = $request->user();

        abort_if($user->isEmailVerified(), 400, ('Email is already verified'));

        $user->notify(new VerifyEmail);
    }
}
