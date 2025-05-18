<?php

namespace App\Http\Controllers\Preferences;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoggedInResource;
use App\Models\User\Profile;
use Illuminate\Http\Request;

class PreferenceSetDarkController extends Controller
{
    public function __invoke (Request $request) {
        $user = $request->user();
        $preferences = $user->profile->preferences;
        
        $preferences['defaultDark'] = $request->input("themeName");
        $user->profile->preferences = $preferences;
        $user->profile->save();

        return new LoggedInResource($user->loadAbilities());
    }
}