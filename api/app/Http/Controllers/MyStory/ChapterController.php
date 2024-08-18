<?php

namespace App\Http\Controllers\MyStory;

use App\Http\Resources\StoryListResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChapterResource;
use App\Models\Chapter;
use Illuminate\Contracts\Database\Query\Builder;
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
        return new ChapterResource($chapter->load(['story']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $chapter = Chapter::create([
            'story_id' => $request->input('story_id'),
            'chapter_number' => $request->input('chapter_number') ?? 0,
            'title' => $request->input('title'),
            'summary' => $request->input('summary'),
            'content' => $request->input('content'),
            'word_count' => $request->input('word_count'),
            'notes' => $request->input('notes'),
        ]);

        return new ChapterResource($chapter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $chapter = Chapter::where('id', $id)->first();
        $chapter->fill($request->only(['chapter_number', 'title', 'summary', 'content', 'word_count', 'notes']));
        $chapter->save();

        return new ChapterResource($chapter);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chapter $chapter)
    {
        //
    }
}