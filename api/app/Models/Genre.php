<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * A genre can belong to many stories
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stories() : BelongsToMany
    {
        return $this->belongsToMany(Story::class, 'stories_genres', 'genre_id', 'story_id');
    }
}
