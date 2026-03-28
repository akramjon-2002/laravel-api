<?php

namespace App\Enums;

enum TaskStatus: string
{
    case New = 'new';
    case InProgress = 'in_progress';
    case Completed = 'completed';

    public static function activeValues(): array
    {
        return [
            self::New->value,
            self::InProgress->value,
        ];
    }
}
