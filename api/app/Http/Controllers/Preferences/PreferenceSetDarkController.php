<?php

namespace App\Http\Controllers\Preferences;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoggedInResource;
use App\Models\User\Profile;
use Illuminate\Http\Request;

class PreferenceSetDarkController extends Controller
{
    public function __invoke (Request $request, $id) {
        $profile = Profile::where('user_id', $id)->first();

        $preferences = $profile->preferences;
        $preferences['defaultDark'] = $request->input("themeName");
        $profile->preferences = $preferences;
        $profile->save();

        return new LoggedInResource($profile->user()->first()->load('abilities'));
    }
}