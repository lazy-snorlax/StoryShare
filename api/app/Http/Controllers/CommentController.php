<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Chapter;
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

            // Fill polymorphic cols
            'commentable_id' => $request->input('chapter_id'),
            'commentable_type' => Chapter::class,

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
        return new CommentResource($comment);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        abort_if($comment->user_id !== auth()->user()->id, 401, 'You are not authorized to do this.');
        // dd($request->input(), $comment);
        $comment->fill($request->only('content'));
        $comment->save();
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        abort_if($comment->user_id !== auth()->user()->id, 401, 'You are not authorized to do this.');

        // TODO: Delete replies of replies
        $comment->replies()->delete();
        $comment->delete();
        return response()->json(null);
    }
}
