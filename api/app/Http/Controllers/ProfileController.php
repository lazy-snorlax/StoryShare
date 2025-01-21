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
        // dd(Bookmark::query()->where('user_id', $profile->user()->first()->id)->leftJoin('stories', 'bookmarks.story_id', '=', 'stories.id')->toRawSql());
        // dd(Story::query()->join('bookmarks', 'bookmarks.story_id', '=', 'stories.id')->where('bookmarks.user_id', $profile->user()->first()->id)->canAccess(auth()->user())->get());
        // dd($profile->user()->first()->bookmarks()->limit(4)->orderBy('updated_at', 'desc')->toRawSql());
        return new ProfileResource($profile);
    }

    // UPDATE
    public function update(Request $request, $id) {
        dd('update profile');
    }
}