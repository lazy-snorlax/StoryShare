<?php

namespace App\Http\Controllers;

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
        return Storage::disk('local')->response($profile->avatar);        
    }

    public function store(Request $request, $id)
    {
        // dd($request->hasFile('file'), $request->file('file'), $id, $request);
        if ($request->hasFile('file')) {
            $profile = Profile::where('user_id', $id)->first();

            $file = $request->file("file");
            $path = $file->store('images/' . $profile->user_id); //->move(public_path('images'), $imageName);
    
            $profile->avatar = $path;
            $profile->save();
        }

        // $profile->recent_stories = $profile->user()->first()->stories()->canAccess(auth()->user())->limit(4)->orderBy('updated_at', 'desc')->get();
        // $profile->recent_bookmarks = Story::query()->join('bookmarks', 'bookmarks.story_id', '=', 'stories.id')->where('bookmarks.user_id', $profile->user()->first()->id)->canAccess(auth()->user())->get();

        return new ProfileResource($profile);
    }
}