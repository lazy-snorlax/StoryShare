<?php

namespace App\Models;

use App\Support\Enums\RoleType;
use App\Support\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;
use Silber\Bouncer\Database\Role as BouncerRole;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends BouncerRole
{
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'scope',
        'type',
        'restricted',
    ];

    protected $casts = [
        'type' => RoleType::class,
        'restricted' => 'boolean',
    ];

    public function scopeAdmin(Builder $query): void
    {
        $query->where('type', RoleType::Admin->value);
    }

    public function scopeUnrestricted(Builder $query): void
    {
        $query->where('restricted', false);
    }

    public function isUser(): bool
    {
        return $this->type === RoleType::User;
    }

    public function enum(): Attribute
    {
        return new Attribute(get: fn () => UserRole::from($this->name));
    }
}