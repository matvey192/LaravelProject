<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	use HasFactory;
//    const PLATFORMS = ['WordPress','Bitrix','Custom','Other'];
//    const STATUSES = ['development','production','maintenance','archived'];

    protected $fillable = [
        'name',
        'url',
        'platform',
        'status',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Проверка платформы
//    public static function isValidPlatform(string $platform): bool
//    {
//        return in_array($platform, self::PLATFORMS);
//    }

    // Проверка статуса
//    public static function isValidStatus(string $status): bool
//    {
//        return in_array($status, self::STATUSES);
//    }

    // Фильтрация по платформе
    public function scopePlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }

    // Фильтрация по статусу
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

}
