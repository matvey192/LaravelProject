<?php

namespace Tests\Integration;

use App\Enums\ProjectStatusEnum;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testCanUpdateProject()
    {
        $project = Project::factory()->create();

        $response = $this->putJson("/api/projects/{$project->id}", [
            'name' => 'Updated Name',
            'status' => ProjectStatusEnum::PRODUCTION,
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Updated Name',
            'status' => ProjectStatusEnum::PRODUCTION,
        ]);
    }
}
