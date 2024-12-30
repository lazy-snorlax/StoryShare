<?php

namespace App\Support\Enums;

enum RoleType: string
{
    case Admin = 'admin';
    case User = 'user';
}