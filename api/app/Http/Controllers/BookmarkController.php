<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bookmark;
use App\Models\Story;
use Illuminate\Http\Request;
use App\Http\Resources\StoryListCollection;
use App\Http\Resources\BookmarkListCollection;
use App\Http\Resources\BookmarkResource;

class BookmarkController extends Controller
{
    /**
     * Display a listing of user bookmarks.
     */
    public function index(Request $request)
    {
        $query = $request->user()->bookmarks()->with('story');

        return new BookmarkListCollection($query->paginate());
    }

    /**
     * Store a newly created bookmark.
     */
    public function store(Request $request)
    {
        $bookmark = Bookmark::create([
            'user_id' => $request->user()->id,
            'story_id' => $request->input('story_id'),
            'private' => $request->input('private'),
            'notes' => $request->input('notes'),
        ]);

        return new BookmarkResource($bookmark);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookmark $bookmark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookmark $bookmark)
    {
        //
    }
}
