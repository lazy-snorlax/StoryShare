<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\User\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // GET
    public function show($id) {
        $profile = Profile::where('id', $id)->first();
        return new ProfileResource($profile);
    }

    // UPDATE
    public function update(Request $request, $id) {
        dd('update profile');
    }
}