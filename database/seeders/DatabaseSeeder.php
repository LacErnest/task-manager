<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Project::factory()->count(10)->create();
    }
}
