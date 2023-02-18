<?php

namespace App\Enum;

enum TicketStatusEnums: int
{
    case Unresolved = 1;
    case Resolved = 2;
    case Frozen = 3;
    case Waiting = 4;
    case InProcess = 5;
}
