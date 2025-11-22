<?php

namespace App\Enum;

enum Status: string
{
    case active = 'active';
    case pending = 'pending';
    case expired = 'expired';
    case completed = 'completed';
    case cancelled = 'cancelled';
}
