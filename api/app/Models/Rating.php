<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * A rating can belong to many stories
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stories() : HasMany
    {
        return $this->hasMany(Story::class, 'rating_id');
    }
}
