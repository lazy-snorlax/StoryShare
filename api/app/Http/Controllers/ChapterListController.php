<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChapterListResource;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterListController extends Controller
{
    public function __invoke($id)
    {
        abort_if($id == null, '400', 'No story id detected.');

        return ChapterListResource::collection(
            Chapter::where('story_id', $id)->get()
        );
    }
}