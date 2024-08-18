<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'notes',
        'number_of_chapters',
        'visible',
        'posted',
        'complete',
    ];

    protected $hidden = [];

    protected $casts = [
        'summary' => PurifyHtmlOnGet::class,
        'notes' => PurifyHtmlOnGet::class,
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

    /**
     * A story can have many genres
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres() : BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'stories_genres', 'story_id', 'genre_id');
    }

    /**
     * A story can have many bookmarks
     */
    public function bookmarks() : HasMany
    {
        return $this->hasMany(Bookmark::class, 'story_id', 'id');
    }

    /**
     * A story can have multiple users appluading
     */
    public function applause() : HasMany
    {
        return $this->hasMany(Applause::class, 'story_id', 'id');
    }

    /**
     * A story can have many comments
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    /**
     * Scopes
     */
    public function scopePublic($query) {
        $query->where('visible', 'public');
    }

    public function scopeAuthenticated($query) {
        $query->whereIn('visible', ['public', 'protected']);
    }

    public function scopeCanAccess($query, $user) {
        $query->when($user, function($query) {
            $query->authenticated();
        })
        ->when(!$user, function($query) {
            $query->public();
        });
    }
}
