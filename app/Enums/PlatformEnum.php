<?php

namespace App\Enums;

final class PlatformEnum
{
    public const WORDPRESS = 'WordPress';
    public const BITRIX     = 'Bitrix';
    public const CUSTOM     = 'Custom';
    public const OTHER      = 'Other';

    public static function getValues(): array
    {
        return [
            self::WORDPRESS,
            self::BITRIX,
            self::CUSTOM,
            self::OTHER,
        ];
    }

    public static function isValid(string $value): bool
    {
        return in_array($value, self::getValues(), true);
    }
}
