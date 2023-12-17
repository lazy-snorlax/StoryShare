<?php

namespace App\Http\Controllers\MyStory;

use App\Http\Resources\StoryListResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoryResource;
use App\Models\Story;
use Illuminate\Contracts\Database\Query\Builder;
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

        return StoryListResource::collection($query);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($story)
    {
        abort_if(auth()->user()->id != $story->user_id, 400, 'You do not have access to this story.');
        return new StoryResource(Story::where('id', $story)->with('chapters')->first());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Story $story)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Story $story)
    {
        dd('update story', $story, $request->input());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Story $story)
    {
        //
    }
}
