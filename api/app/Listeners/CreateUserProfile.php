<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\User\Profile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserProfile
{
    /**
     * Handle the event.
     */
    public function __invoke(UserRegistered $event): void
    {
        $profile = new Profile([ 
            'user_id' => $event->user->id,
            'language' => 'en'
        ]);
        $profile->save();
    }
}
