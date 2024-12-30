<?php

namespace App\Models\User;

use Silber\Bouncer\Database\Ability as BouncerAbility;

class Ability extends BouncerAbility
{
    protected static $cache;

    protected $fillable = ['name', 'title', 'group', 'excludes', 'options'];

    protected $casts = [
        'id' => 'int',
        'entity_id' => 'int',
        'only_owned' => 'boolean',
        'excludes' => 'json',
        'options' => 'json',
    ];
}