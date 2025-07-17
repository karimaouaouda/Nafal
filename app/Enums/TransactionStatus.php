<?php

namespace App\Enums;

enum TransactionStatus : string
{
    case PROCESSING = 'processing';

    case CANCELLED = 'cancelled';

    case FINISHED = 'finished';


    public static function values(): array
    {
        $values = [];

        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }

    public static function asAssocArray(): array
    {
        $assocArray = [];
        foreach (self::cases() as $case) {
            $assocArray[$case->value] = $case->name;
        }

        return $assocArray;
    }
}
