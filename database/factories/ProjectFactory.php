<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\PlatformEnum;
use App\Enums\ProjectStatusEnum;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $platforms = PlatformEnum::getValues();
        $statuses  = ProjectStatusEnum::getValues();

        return [
            'name' => $this->faker->company,
            'url' => $this->faker->url,
            'platform' => $this->faker->randomElement($platforms),
            'status' => $this->faker->randomElement($statuses),
            'description' => $this->faker->optional()->sentence,
        ];
    }
}
