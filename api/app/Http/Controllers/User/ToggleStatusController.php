<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Support\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class ToggleStatusController extends Controller
{
    public function update(User $user): UserResource
    {
        // $this->authorize('update', $user);
        
        if ($user->status === UserStatus::Enabled || $user->status === UserStatus::Pending) {
            $user->status = UserStatus::Banned;
        } else {
            // if user has already verified their email they don't need to do it again
            if (!$user->email_verified_at) {
                $user->status = UserStatus::Pending;
                $user->sendEmailVerificationNotification();
            } else {
                $user->status = UserStatus::Enabled;
            }
        }

        $user->save();

        return new UserResource($user);
    }
}
