<?php

namespace Tests\Integration;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testCanGetProjectsList()
    {
        Project::factory()->count(3)->create();

        $response = $this->getJson('/api/projects');

        $response->assertOk()
            ->assertJsonCount(3, 'data');
    }
}
