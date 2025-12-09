<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Enums\PlatformEnum;
use App\Enums\ProjectStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testCanGetProjectsList()
    {
        Project::factory()->count(5)->create();

        $response = $this->getJson('/api/projects');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'url', 'platform', 'status', 'description', 'created_at', 'updated_at']
                ],
                'links',
                'meta'
            ]);
    }

    /** @test */
    public function testCanCreateProject()
    {
        $data = [
            'name' => 'Test Project',
            'url' => 'https://example.com',
            'platform' => PlatformEnum::WORDPRESS,
            'status' => ProjectStatusEnum::DEVELOPMENT,
            'description' => 'Test description'
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Test Project']);

        $this->assertDatabaseHas('projects', ['name' => 'Test Project']);
    }

    /** @test */
    public function testReturns404NonexistentProject()
    {
        $response = $this->getJson('/api/projects/999999');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'success',
                'code',
                'message',
                'error',
            ]);
    }

    /** @test */
    public function testCanUpdateProject()
    {
        $project = Project::factory()->create();

        $data = ['name' => 'Updated Name'];

        $response = $this->putJson("/api/projects/{$project->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'name' => 'Updated Name']);
    }

    /** @test */
    public function testCanDeleteProject()
    {
        $project = Project::factory()->create();

        $response = $this->deleteJson("/api/projects/{$project->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    /** @test */
    public function testCanCheckProjectUrl()
    {
        $project = Project::factory()->create(['url' => 'https://example.com']);

        $response = $this->getJson("/api/projects/{$project->id}/check");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'http_code',
                'response_time_ms',
                'checked_at',
            ]);
    }
}
