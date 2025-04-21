<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Preparing = 'preparing';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return array_map(fn($case) => ['label' => ucfirst($case->value), 'value' => $case->value], self::cases());
    }
}
