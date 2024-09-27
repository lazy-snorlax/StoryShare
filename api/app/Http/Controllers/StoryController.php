<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use App\Http\Resources\StoryResource;
use App\Http\Resources\StoryListResource;
use App\Http\Resources\StoryListCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(Request $request)
    {
        // dd(auth()->user());
        // dd($request->post('genre'), array_column($request->post('genre'), 'id'));
        $query = Story::query()
            ->when($request->post('search'), function($query, $search) {
                $query->whereSearchByWords($search, [ 'title', 'summary' ]);
            })
            ->when($request->post('author'), function($query, $author) {
                $query->whereHas('user', function ($q) use ($author) {
                    $q->where('users.name', 'like', '%'.$author.'%');
                });
            })
            ->canAccess(auth()->user())
            ->when($request->post('sort'), function ($query, $sort) {
                if (str_starts_with($sort, '-')){
                    $query->orderBy(substr($sort, 1), 'desc');
                } else {
                    $query->orderBy($sort, 'desc');
                }
            })
            ->when($request->post('genre'), function ($query, $genre) {
                $query->whereHas('genres', function ($q) use ($genre) {
                    $q->whereIn('genres.id', array_column($genre, 'id'));
                });
            })
            ->withCount('applause')
            ;

        // dd($query->toRawSql());
        // dd($query->get());

        return new StoryListCollection($query->paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(Story $story)
    {
        abort_if($story->visible == null, 404, 'Internal Server error. Story not found');
        abort_if(!auth()->user() && $story->visible != 'public', 403, 'You must login to view this story');

        abort_if(
            (auth()->user() && auth()->user()->id != $story->user_id)
            && $story->visible == 'private',
            403, 
            'You don\'t have access to this story'
        );

        return new StoryResource($story->load('chapters', 'genres', 'bookmarks', 'applause'));
    }
}
