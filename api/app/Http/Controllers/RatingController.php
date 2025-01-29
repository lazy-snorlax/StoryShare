<?php

namespace App\Http\Controllers;

use App\Http\Resources\RatingListResource;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Rating::query()
        ->when(!auth()->user(), function ($query) {
            $query->where('id', '!=', 5);
        })
        ->get();

        return RatingListResource::collection($query);
    }
}
