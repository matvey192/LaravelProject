<?php

namespace Tests\Integration;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testCanDeleteProject()
    {
        $project = Project::factory()->create();

        $response = $this->deleteJson("/api/projects/{$project->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }
}
