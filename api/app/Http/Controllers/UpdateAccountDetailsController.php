<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\LoggedInResource;
use Illuminate\Auth\Notifications\VerifyEmail;

class UpdateAccountDetailsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        if (($email = $request->input('email')) !== $user->email) {
            
            // TODO: Debug send verification email
            $user->update([
                'email' => $email,
                'email_verified_at' => null,
            ]);
            $user->save();
            // $request->user()->notify(new VerifyEmail);
        }
        // $user->fill($request->only(['name', 'email']));
        // $user->save();

        return new LoggedInResource($user);
    }
}
