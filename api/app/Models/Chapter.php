<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'story_id',
        'chapter_number',
        'title',
        'summary',
        'content',
        'notes',
    ];

    protected $hidden = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * A chapter belongs to a story
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function story() : BelongsTo
    {
        return $this->belongsTo(Story::class);
    }
}
