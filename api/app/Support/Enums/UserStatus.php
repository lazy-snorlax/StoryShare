<?php

namespace App\Support\Enums;

enum UserStatus: string
{
    case Enabled = 'enabled';
    case Pending = 'pending';
    case Banned = 'banned';

    public function title(): string
    {
        return match ($this) {
            self::Enabled => 'Enabled',
            self::Pending => 'Pending',
            self::Banned => 'Banned'
        };
    }

    public function class(): string
    {
        return match ($this) {
            self::Enabled => 'status-success',
            self::Pending => 'status-info',
            self::Banned => 'status-danger'
        };
    }
}
