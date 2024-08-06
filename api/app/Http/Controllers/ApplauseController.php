<?php

namespace App\Http\Controllers;

use App\Models\Applause;
use Illuminate\Http\Request;

class ApplauseController extends Controller
{
    public function store(Request $request) {
        // dd($request->user()->id);
        // TODO: Check if story id exists in db


        // TODO: Check if user trying to applaud own story


        // Check if applause is already in db
        $applauseCheck = Applause::query()
        ->when($request->user() != null, function ($query, $user_id) {
            $query->where('user_id', '=', $user_id);
        })
        ->when($request->input('ip_address', null), function ($query, $ip_address) {
            $query->where('ip_address', '=', $ip_address);
        })->count();

        // abort_if already present
        abort_if($applauseCheck > 0, '504', 'You have already applauded this story');

        // add applause to db
        Applause::create([
            'story_id' => $request->input('story_id'),
            'user_id' => $request->user()->id,
            'ip_address' => $request->input('ip_address'),
        ]);

        return response()->json('You applauded this story');
    }
}