<?php

namespace App\Http\Controllers\Register;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\VerifyEmail;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class ResendVerificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        /** @var \App\Models\User */
        $user = $request->user();

        abort_if($user->isEmailVerified(), new DetailedReason('Email is already verified'));

        $user->notify(new VerifyEmail);
    }
}
