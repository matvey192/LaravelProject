<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        Project::create([
            'name' => 'Test Website',
            'url' => 'https://example.com',
            'platform' => 'WordPress',
            'status' => 'production',
            'description' => 'website.',
        ]);

        Project::create([
            'name' => 'test2 website',
            'url' => 'https://exampfwdwdsad.com',
            'platform' => 'Custom',
            'status' => 'development',
            'description' => 'website2',
        ]);
    }
}
