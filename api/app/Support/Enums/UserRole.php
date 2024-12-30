<?php

namespace App\Support\Enums;

use App\Models\Role as Model;

enum UserRole: string
{
    case Admin = 'admin';
    case Moderator = 'moderator';
    case User = 'user';

    public static function user() : array 
    {
        return [ self::User ];
    }

    public static function admin() : array
    {
        return [ self::Admin ];
    }

    public function title(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::User => 'User',
        };
    }

    public function model(): ?Model
    {
        return Model::firstWhere(['name' => $this->value]);
    }
}