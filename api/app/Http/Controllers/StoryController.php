<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoryListResource;
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
        // dd(auth()->user());
        // dd($request->post('genre'), array_column($request->post('genre'), 'id'));
        $query = Story::query()
            ->when($request->post('search'), function($query, $search) {
                if ($search !== 'null') {
                    $query->whereSearchByWords($search, [ 'title', 'summary' ]);
                }
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
            ;
        // dd($query->toRawSql());

        return StoryListResource::collection($query->get()->load('user', 'genres'));
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
    public function show(Story $story)
    {
        abort_if(!auth()->user() && $story->visible != 'public', 400, 'You must login to view this story');

        abort_if(
            (auth()->user() && auth()->user()->id != $story->user_id)
            && $story->visible == 'private',
            400, 
            'You don\'t have access to this story'
        );

        return new StoryResource($story->load('user', 'chapters', 'genres'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Story $story)
    {
        //
    }
}
