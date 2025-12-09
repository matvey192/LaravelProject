<?php

namespace Tests\Unit;

use App\Enums\PlatformEnum;
use App\Enums\ProjectStatusEnum;
use App\Models\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectModelTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function testModelHasExpectedFillableFields()
    {
        $project = new Project();

        $this->assertEquals([
            'name',
            'url',
            'platform',
            'status',
            'description',
        ], $project->getFillable());
    }

    /** @test */
    public function testModelCastsAreCorrect()
    {
        $project = new Project();

        $this->assertArrayHasKey('created_at', $project->getCasts());
        $this->assertArrayHasKey('updated_at', $project->getCasts());
    }

    /** @test */
    public function testScopePlatformFiltersCorrectly()
    {
        Project::factory()->create(['platform' => PlatformEnum::WORDPRESS]);
        Project::factory()->create(['platform' => PlatformEnum::BITRIX]);

        $result = Project::platform(PlatformEnum::WORDPRESS)->get();

        $this->assertCount(1, $result);
        $this->assertEquals(PlatformEnum::WORDPRESS, $result->first()->platform);
    }

    /** @test */
    public function testScopeStatusFiltersCorrectly()
    {
        Project::factory()->create(['status' => ProjectStatusEnum::DEVELOPMENT]);
        Project::factory()->create(['status' => ProjectStatusEnum::PRODUCTION]);

        $result = Project::status(ProjectStatusEnum::PRODUCTION)->get();

        $this->assertCount(1, $result);
        $this->assertEquals(ProjectStatusEnum::PRODUCTION, $result->first()->status);
    }
}
