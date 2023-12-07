<?php

namespace App\Http\Controllers\Register;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Egulias\EmailValidator\Result\Reason\DetailedReason;

class VerificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        /** @var \App\Models\User */
        $user = User::query()->findOrFail($request->input('id'));

        // TODO: Check signature in request is valid and match email verification signature parameters.
        // abort_unless(
        //     $request->hasValidSignature($user->emailVerificationSignatureParameters()), 403,
        //     (new DetailedReason('Email verification signature is invalid'))
        // );

        // Email must not already be verified.
        abort_if($user->isEmailVerified(), 'Email is already verified');

        $user->markEmailAsVerified();

        return response()->noContent();
    }
}
