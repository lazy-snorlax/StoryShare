<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model 
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'avatar',
        'language',
        'about_me',
        'preferences',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'preferences' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}