<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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


    /**
     * A bookmark has one story
     * 
     * @return 
     */
    public function story() : BelongsTo
    {
        return $this->belongsTo(Story::class, 'id', 'story_id');
    }

    /**
     * A bookmark belongs to one user
     * 
     * @return 
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
