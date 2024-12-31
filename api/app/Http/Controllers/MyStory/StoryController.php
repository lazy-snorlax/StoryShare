<?php

namespace App\Http\Controllers\MyStory;

use App\Http\Resources\StoryListResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoryResource;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $query = Story::query()
        //     ->when($request->input('user_id'), fn (Builder $q, $user_id) => $q->where('user_id', $user_id))
        //     ->orderBy('updated_at', 'desc')
        //     ->get();

        $user = $request->user();

        $query = Story::with('user')
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return StoryListResource::collection($query->load('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $story = Story::create([
            'user_id' => $request->user()->id,
            'title' => $request->input('title'),
            'summary' => $request->input('summary'),
            'rating_id' => $request->input('rating'),
            'notes' => $request->input('notes'),
            'number_of_chapters' => $request->input('number_of_chapters'),
            'posted' => false,
            'word_count' => 0,
            'complete' => false,
        ]);

        // TODO: Create record in pivot when story created
        // $story->genres()->attach($request->input('genres'));

        return new StoryResource($story);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $story = Story::where('id', $id)->first();

        abort_if(auth()->user()->id != $story->user_id, 400, 'You do not have access to this story.');

        return new StoryResource($story->load('chapters', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $story = Story::where('id', $id)->first();
        $story->fill($request->only(['title', 'summary', 'notes', 'visible', 'number_of_chapters']));
        $story->rating_id = $request->input('rating');
        $story->save();

        // TODO: Update story genres records
        $story->genres()->sync(array_column($request->input('genres'), 'id'));

        return new StoryResource($story->load('genres'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Story $story)
    {
        // TODO: Delete story genres records
        // $story->genres()->detach();

        $story->delete();
    }
}
