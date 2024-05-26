<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'private',
        'notes',
        'user_id',
        'story_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'notes' => PurifyHtmlOnGet::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
