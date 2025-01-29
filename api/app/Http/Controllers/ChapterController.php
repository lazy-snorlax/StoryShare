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
    // public function index(Request $request)
    // {
    //     $story_id = $request->input('story_id');
    //     abort_if(!$story_id, '400', 'No story id detected');

    //     $chapters = Chapter::where('story_id', $story_id);        
    //     return ChapterResource::collection($chapters->get());
    // }

    /**
     * Show a single chapter 
     */
    public function show(Chapter $chapter)
    {
        return new ChapterResource($chapter->load(['story', 'comments']));
    }
}
