<?php

namespace App\Support\Enums;

enum UserAbility: string
{
    case ReadUsers = 'read users';
    case WriteUsers = 'write users';
    case ReadBan = 'read ban';
    case WriteBan = 'write ban';
    case ReadComment = 'read comment';
    case WriteComment = 'write comment';

    public static function grouped(): array
    {
        return [
            'users' => [
                'read' => ['name' => self::ReadUsers, 'excludes' => [RoleType::User]],
                'write' => ['name' => self::WriteUsers, 'excludes' => [RoleType::User]],
            ],
            'ban-users' => [
                'read' => ['name' => self::ReadBan, 'excludes' => [RoleType::User]],
                'write' => ['name' => self::WriteBan, 'excludes' => [RoleType::User]],
            ],
            'comment' => [
                'read' => ['name' => self::ReadComment, 'excludes' => []],
                'write' => ['name' => self::WriteComment, 'excludes' => []],
            ],
        ];
    }
}