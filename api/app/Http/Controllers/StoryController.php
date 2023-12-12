<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoryListResource;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Story::with('user')
            ->when($request->query('search'), function($query, $search) {
                $query->whereSearchByWords($search, [ 'title', 'summary' ]);
            })
            ->when($request->query('sort'), function ($query, $sort) {
                if (str_starts_with($sort, '-')){
                    $query->orderBy(substr($sort, 1), 'desc');
                } else {
                    $query->orderBy($sort, 'asc');
                }
            });

        return StoryListResource::collection($query->get());
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
        //
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
