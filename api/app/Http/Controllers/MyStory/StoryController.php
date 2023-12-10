<?php

namespace App\Http\Controllers\MyStory;

use App\Http\Resources\StoryListResource;
use App\Http\Controllers\Controller;
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

        $query = Story::query()
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
