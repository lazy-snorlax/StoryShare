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
        // dd($request->input(), $request->input("theme")["dark"]);
        $preferences = $profile->preferences;
        $preferences['themes'][$request->input("themeName")] = [
            "primary" => $request->input("theme")["primary"],
            "primaryAlt" => $request->input("theme")["primaryAlt"],
            "light" => $request->input("theme")["light"],
            "lightAlt" => $request->input("theme")["lightAlt"],
            "dark" => $request->input("theme")["dark"],
            "darkAlt" => $request->input("theme")["darkAlt"],
        ];

        $profile->preferences = $preferences;
        $profile->save();

        return new LoggedInResource($profile->user()->first());
    }
}