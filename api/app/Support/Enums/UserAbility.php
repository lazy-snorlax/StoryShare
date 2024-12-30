<?php

namespace App\Support\Enums;

enum UserAbility: string
{
    case ReadUsers = 'read users';
    case WriteUsers = 'write users';

    public static function grouped(): array
    {
        return [
            'users' => [
                'read' => ['name' => self::ReadUsers, 'excludes' => []],
                'write' => ['name' => self::WriteUsers, 'excludes' => []],
            ],
        ];
    }
}