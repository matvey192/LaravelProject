<?php

namespace Tests\Integration;

use App\Enums\PlatformEnum;
use App\Enums\ProjectStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testCanCreateProjectViaApi()
    {
        $data = [
            'name' => 'Test site',
            'url' => 'https://example.com',
            'platform' => PlatformEnum::WORDPRESS,
            'status' => ProjectStatusEnum::DEVELOPMENT,
            'description' => 'text',
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertCreated()
            ->assertJsonFragment(['name' => 'Test site']);

        $this->assertDatabaseHas('projects', [
            'name' => 'Test site',
            'platform' => PlatformEnum::WORDPRESS,
        ]);
    }
}
