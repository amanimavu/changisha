<?php

namespace App\Enum;

enum Status
{
    case active;
    case expired;
    case completed;
    case cancelled;
}
