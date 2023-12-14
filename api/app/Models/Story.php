<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'notes',
        'number_of_chapters',
        'posted',
        'word_count',
        'complete',
    ];

    protected $hidden = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * A story belongs to a user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A story can have many chapters
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters() : HasMany
    {
        return $this->hasMany(Chapter::class);
    }
}
