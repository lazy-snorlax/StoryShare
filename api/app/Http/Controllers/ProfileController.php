<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Bookmark;
use App\Models\User\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // GET
    public function show($id) {
        $profile = Profile::where('id', $id)->first();
        $profile->recent_stories = $profile->user()->first()->stories()->canAccess(auth()->user())->limit(4)->orderBy('updated_at', 'desc')->get();
        $profile->recent_bookmarks = $profile->user()->first()->bookmarks()->limit(4)->orderBy('updated_at', 'desc')->get();
        // dd(Bookmark::query()->where('user_id', $profile->user()->first()->id)->leftJoin('stories', 'bookmarks.story_id', '=', 'stories.id')->toRawSql(););
        // dd($profile->user()->first()->bookmarks()->limit(4)->orderBy('updated_at', 'desc')->toRawSql());
        return new ProfileResource($profile);
    }

    // UPDATE
    public function update(Request $request, $id) {
        dd('update profile');
    }
}