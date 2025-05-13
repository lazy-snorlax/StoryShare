<?php

namespace App\Http\Controllers\Preferences;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoggedInResource;
use App\Models\User\Profile;
use Illuminate\Http\Request;

class PreferenceThemeController extends Controller
{
    public function store(Request $request, $id) {
        $profile = Profile::where('user_id', $id)->first();
        $preferences = $profile->preferences;
        $preferences['themes'][$request->input("themeName")] = [
            "primary" => $request->input("theme")["primary"],
            "primaryAlt" => $request->input("theme")["primaryAlt"],
            "light" => $request->input("theme")["light"],
            "lightAlt" => $request->input("theme")["lightAlt"],
            "dark" => $request->input("theme")["dark"],
            "darkAlt" => $request->input("theme")["darkAlt"],

            "white" => $request->input("theme")["white"],
            "grey" => $request->input("theme")["grey"],
            "black" => $request->input("theme")["black"],
        ];

        $profile->preferences = $preferences;
        $profile->save();

        return new LoggedInResource($profile->user()->first()->load('abilities'));
    }

    public function destroy(Request $request, $id) {
        $profile = Profile::where('user_id', $id)->first();

        $preferences = $profile->preferences;
        if ($preferences['defaultDark'] == $request->input("themeName")) {
            $preferences['defaultDark'] = null;
        }
        unset($preferences['themes'][$request->input("themeName")]);
        
        $profile->preferences = $preferences;
        $profile->save();

        return new LoggedInResource($profile->user()->first()->load('abilities'));
    }
}