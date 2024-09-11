<?php

namespace App\Support\Enums;

enum UserStatus: string
{
    case Enabled = 'enabled';
    case Pending = 'pending';
    case Archived = 'archived';

    public function title(): string
    {
        return match ($this) {
            self::Enabled => 'Enabled',
            self::Pending => 'Pending',
            self::Archived => 'Archived'
        };
    }

    public function class(): string
    {
        return match ($this) {
            self::Enabled => 'status-success',
            self::Pending => 'status-info',
            self::Archived => 'status-danger'
        };
    }
}
