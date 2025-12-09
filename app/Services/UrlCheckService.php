<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

class UrlCheckService
{
	
    public function check(string $url): array
    {
        $checkedAt = now();

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Invalid URL: {$url}");
        }

        $start = microtime(true);

        try {
            $response = Http::timeout(5)->get($url);

            $statusCode = $response->status();
            $isAvailable = $response->successful();

            $durationMs = round((microtime(true) - $start) * 1000);

            return [
                'status' => $isAvailable ? 'available' : 'unavailable',
                'http_code' => $statusCode,
                'response_time_ms' => $durationMs,
                'checked_at' => $checkedAt,
            ];
        } catch (\Exception $e) {
            Log::warning("UrlCheckService: URL check failed for {$url}", [
                'error' => $e->getMessage(),
            ]);

            return [
                'status' => 'unavailable',
                'http_code' => 0,
                'response_time_ms' => null,
                'checked_at' => $checkedAt,
                'error_message' => $e->getMessage(),
            ];
        }
    }
}
