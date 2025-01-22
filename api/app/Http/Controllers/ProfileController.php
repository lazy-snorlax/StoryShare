<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Bookmark;
use App\Models\Story;
use App\Models\User\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // GET
    public function show($id) {
        $profile = Profile::where('id', $id)->first();

        $profile->recent_stories = $profile->user()->first()->stories()->canAccess(auth()->user())->limit(4)->orderBy('updated_at', 'desc')->get();
        
        $profile->recent_bookmarks = Story::query()->join('bookmarks', 'bookmarks.story_id', '=', 'stories.id')->where('bookmarks.user_id', $profile->user()->first()->id)->canAccess(auth()->user())->get();
        return new ProfileResource($profile);
    }

    // UPDATE
    public function update(Request $request, $id) {
        $profile = Profile::where('id', $id)->first();
        // dd($id, $profile);

        abort_if($profile == null, 404, 'Profile no found');
        abort_if($request->user()->id != $profile->user_id, 401, 'You do not have access to this profile.');

        $profile->fill($request->only(['language', 'about_me']));
        $profile->save();

        $profile->recent_stories = $profile->user()->first()->stories()->canAccess(auth()->user())->limit(4)->orderBy('updated_at', 'desc')->get();
        $profile->recent_bookmarks = Story::query()->join('bookmarks', 'bookmarks.story_id', '=', 'stories.id')->where('bookmarks.user_id', $profile->user()->first()->id)->canAccess(auth()->user())->get();

        return new ProfileResource($profile);
    }
}