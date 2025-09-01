<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_id',
        'parent_type',
        'commentable_id',
        'commentable_type',
        'content',
        'approved',
        'approved_by',
        'approved_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'content' => PurifyHtmlOnGet::class,
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * A comment belongs to a user
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A comment can have many replies
     */
    public function replies() : HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->with('replies');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
