<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Services\UrlCheckService;
use InvalidArgumentException;

class UrlCheckServiceTest extends TestCase
{
    public function testReturnsAvailableForSuccessfulResponse()
    {
        Http::fake([
            'https://example.com' => Http::response('OK', 200),
        ]);

        $service = new UrlCheckService();
        $result = $service->check('https://example.com');

        $this->assertEquals('available', $result['status']);
        $this->assertEquals(200, $result['http_code']);
    }

    public function testReturnsUnavailableForFailedResponse()
    {
        Http::fake([
            'https://example.com' => Http::response('Error', 500),
        ]);

        $service = new UrlCheckService();
        $result = $service->check('https://example.com');

        $this->assertEquals('unavailable', $result['status']);
        $this->assertEquals(500, $result['http_code']);
    }

    public function testThrowsExceptionForInvalidUrl()
    {
        $this->expectException(InvalidArgumentException::class);

        $service = new UrlCheckService();
        $service->check('invalid-url');
    }
}
