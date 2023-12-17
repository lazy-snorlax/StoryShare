<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'notes',
        'number_of_chapters',
        'visible',
        'posted',
        'word_count',
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
