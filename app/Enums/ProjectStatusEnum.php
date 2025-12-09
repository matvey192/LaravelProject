<?php

namespace App\Enums;

final class ProjectStatusEnum
{
    public const DEVELOPMENT = 'development';
    public const PRODUCTION  = 'production';
    public const MAINTENANCE = 'maintenance';
    public const ARCHIVED    = 'archived';

    public static function getValues(): array
    {
        return [
            self::DEVELOPMENT,
            self::PRODUCTION,
            self::MAINTENANCE,
            self::ARCHIVED,
        ];
    }

    public static function isValid(string $value): bool
    {
        return in_array($value, self::getValues(), true);
    }
}
