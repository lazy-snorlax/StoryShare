<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_id',
        'parent_type',
        'content',
        'approved',
        'approved_by',
        'approved_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * A comment can only have one parent, whether it's a story_id, chapter_id, or another comment_id
     */
}
