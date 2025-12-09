<?php

namespace Tests\Integration;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlCheckIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testCanCheckProjectUrl()
    {
        Http::fake([
            'https://example.com' => Http::response('OK', 200),
        ]);

        $project = Project::factory()->create([
            'url' => 'https://example.com',
        ]);

        $response = $this->getJson("/api/projects/{$project->id}/check");

        $response->assertOk()
            ->assertJsonFragment([
                'status' => 'available',
                'http_code' => 200,
            ]);
    }

}
