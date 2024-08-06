<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applause extends Model
{
    use HasFactory;

    protected $table = 'applause';

    protected $fillable = [
        'story_id',
        'user_id',
        'ip_address'
    ];

    protected $hidden = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}