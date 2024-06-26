<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $taskService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskService = $this->app->make(TaskService::class);
    }

    public function it_stores_a_new_task_and_redirects_to_project_show()
    {
        $project = Project::factory()->create();

        $data = [
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'priority' => 1,
        ];

        $response = $this->post("/project/{$project->id}/task/store", $data);

        $task = Task::first();

        $response->assertRedirect(route('show-project', ['id' => $project->id]));
        $this->assertDatabaseHas('tasks', $data + ['project_id' => $project->id]);
    }

    public function it_updates_task_and_redirects_to_project_show()
    {
        $project = Project::factory()->create();
        $task = Task::factory()->create(['project_id' => $project->id]);

        $data = [
            'title' => 'Updated Task Title',
            'description' => 'Updated task description.',
            'priority' => 2,
        ];

        $response = $this->put("/project/{$project->id}/task/{$task->id}/update", $data);

        $response->assertRedirect(route('show-project', ['id' => $project->id]));
        $this->assertDatabaseHas('tasks', $data + ['id' => $task->id, 'project_id' => $project->id]);
    }

    public function it_deletes_task_and_redirects_to_project_show()
    {
        $project = Project::factory()->create();
        $task = Task::factory()->create(['project_id' => $project->id]);

        $response = $this->delete("/project/task/{$task->id}/delete");

        $response->assertRedirect(route('show-project', ['id' => $project->id]));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
