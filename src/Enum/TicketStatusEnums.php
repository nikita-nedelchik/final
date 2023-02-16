<?php

namespace App\Enum;

enum TicketStatusEnums: int
{
    case Unresolved = 1;
    case Resolved = 2;
    case Frozen = 3;
}
