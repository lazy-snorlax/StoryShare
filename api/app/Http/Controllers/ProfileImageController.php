<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Bookmark;
use App\Models\Story;
use App\Models\User\Profile;
use Illuminate\Http\Request;

class ProfileImageController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        dd($request->hasFile('file'), $request->file('file'), $id, $request);
        if ($request->hasFile('profile_picture')) {
            
        }
    }
}