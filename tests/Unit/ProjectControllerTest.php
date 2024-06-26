<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\Project;
use App\Models\Task;
use App\Services\ProjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $projectService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->projectService = $this->app->make(ProjectService::class);
    }

    public function it_stores_a_new_project_and_redirects_to_show()
    {
        $data = [
            'name' => 'Test Project',
            'description' => 'This is a test project.',
        ];

        $response = $this->post('/project/store', $data);

        $project = Project::first();

        $response->assertRedirect(route('show-project', ['id' => $project->id]));
        $this->assertDatabaseHas('projects', $data);
    }

    public function it_reorders_tasks_for_a_project()
    {
        $project = Project::factory()->create();
        Task::factory()->count(5)->create(['project_id' => $project->id]);

        $tasks = Task::where('project_id', $project->id)->pluck('id')->toArray();

        $response = $this->post("/project/{$project->id}/reorderTasks", [
            'ids' => [$tasks[4], $tasks[0], $tasks[3], $tasks[1], $tasks[2]],
        ]);

        $this->assertEquals([1, 2, 3, 4, 5], Task::where('project_id', $project->id)->pluck('priority')->toArray());
    }
}
