<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Comment::query()
            ->where('parent_id', '=', $request->input('parent_id'))
            ->with('replies')
            ->get();

        return CommentResource::collection($query->load('replies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = Comment::create([
            'user_id' => $request->user()->id,
            'parent_id' => $request->input('parent_id'),
            'parent_type' => 'comment',
            'content' => $request->input('content'),

            // TODO: Make vars not fixed
            'approved' => true,
            'approved_by' => 2,
            'approved_at' => now(),
        ]);

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(null);
    }
}