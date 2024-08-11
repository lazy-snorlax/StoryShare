<?php

namespace App\Http\Controllers;

use App\Models\Applause;
use App\Models\Story;
use Illuminate\Http\Request;

class ApplauseController extends Controller
{
    public function store(Request $request) {
        // Check if story exists in db 
        $storyCheck = Story::query()->where('id', '=', $request->input('story_id'))->first();
        abort_if($storyCheck == null, '504', 'Story cannot be found in database.');


        // Check if logged in user is trying to applaud own story
        if ($request->user()) {
            abort_if($storyCheck->user_id == $request->user()->id, '504', 'You cannot applaude your own story!');
        }

        // Check if applause is already in db, looking up either user_id or stored ip_address
        $applauseCheck = Applause::query()
        ->where('story_id', '=', $request->input('story_id'))
        ->when($request->user() != null, function ($query, $ip_address) use ($request) {
            $query->where('user_id', '=', $request->user()->id);
        })
        ->when($request->input('ip_address') != null, function ($query) use ($request) {
            $query->where('ip_address', '=', $request->input('ip_address'));
        })
        ->count();

        // Prevent multiple apllauses from the same user or ip_address
        abort_if($applauseCheck > 0, '504', 'You have already applauded this story');

        // add applause to db
        Applause::create([
            'story_id' => $request->input('story_id'),
            'user_id' => $request->user() ? $request->user()->id : null,
            'ip_address' => $request->input('ip_address'),
        ]);

        return response()->json('You applauded this story');
    }
}