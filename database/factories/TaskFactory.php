<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project;
use App\Constants\TaskConstants;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'priority' => $this->faker->numberBetween(TaskConstants::TOP, 100),
            'project_id' => Project::factory(),
        ];
    }
}
