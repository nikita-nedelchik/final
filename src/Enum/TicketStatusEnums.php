<?php

namespace App\Enum;

enum TicketStatusEnums: string
{
    case Resolved = 'resolved';
    case Unresolved = 'unresolved';
    case Frozen = 'frozen';
}