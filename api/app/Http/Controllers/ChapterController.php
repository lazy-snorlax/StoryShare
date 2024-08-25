<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChapterResource;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * List all chapters of a story
     */
    public function index(Request $request)
    {
        $story_id = $request->input('story_id');
        abort_if(!$story_id, '400', 'No story id detected');

        $chapters = Chapter::where('story_id', $story_id);        
        return ChapterResource::collection($chapters->get());
    }

    /**
     * Show a single chapter 
     */
    public function show(Chapter $chapter)
    {
        return new ChapterResource($chapter->load(['story', 'comments']));
    }

    // *******************************************************************

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
     * Show the form for editing the specified resource.
     */
    public function edit(Chapter $chapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chapter $chapter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chapter $chapter)
    {
        //
    }
}
