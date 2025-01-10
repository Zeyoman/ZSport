<?php

declare(strict_types=1);

namespace App\Enum;

enum UserAccountStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case BANNED = 'bannis';
    case DELETED = 'deleted';
}