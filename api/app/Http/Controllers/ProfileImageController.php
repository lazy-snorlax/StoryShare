<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoggedInResource;
use App\Http\Resources\ProfileResource;
use App\Models\Bookmark;
use App\Models\Story;
use App\Models\User\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileImageController extends Controller
{
    public function show(Request $request, $id) {
        $profile = Profile::where('user_id', $id)->first();
        abort_if($profile->avatar == null, 501, 'Profile image not found');
        
        return Storage::disk('local')->response($profile->avatar);        
    }

    public function store(Request $request, $id)
    {
        // dd($request->hasFile('file'), $request->file('file'), $id, $request);
        $profile = Profile::where('user_id', $id)->first();

        abort_if($profile == null, 404, 'Profile not found');
        abort_if($request->user()->id != $profile->user_id, 401, 'You do not have access to this profile.');

        if ($request->hasFile('file')) {
            // Delete existing
            if ($profile->avatar != null) {
                Storage::disk('local')->delete($profile->avatar);
                $profile->avatar = null;
                $profile->save();
            }

            // Upload new
            $file = $request->file("file");
            $path = $file->store('images/' . $profile->user_id); 
    
            // Store path in model
            $profile->avatar = $path;
            $profile->save();
        }

        return new LoggedInResource($profile->user()->first());
    }
}