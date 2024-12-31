<?php

namespace App\Http\Controllers\Register;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Register\RegisterRequest;
use App\Http\Resources\User as UserResource;
use App\Notifications\VerifyEmail;
use App\Support\Enums\UserRole;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

class RegisterController extends Controller
{
    /**
     * Register a new user account
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = new User([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
        ]);

        $user->password = $request->validated('password');
        $user->save();

        $user->assign(UserRole::User->value);

        $user->notify(new VerifyEmail);

        return new UserResource($user);
    }
}
