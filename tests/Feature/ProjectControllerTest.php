<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $projectService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->projectService = Mockery::mock(ProjectService::class);
        $this->app->instance(ProjectService::class, $this->projectService);
    }

    public function testIndex()
    {
        $projects = Project::factory()->count(3)->create();
        $this->projectService->shouldReceive('getAllProjects')->once()->andReturn($projects);

        $response = $this->get('/project/index');

        $response->assertStatus(200)
                 ->assertViewIs('project.index')
                 ->assertViewHas('projects', $projects);
    }

    public function testCreate()
    {
        $response = $this->get('/project/create');

        $response->assertStatus(200);
        $response->assertViewIs('project.create');
    }

    public function testStore()
    {
        $projectData = ['title' => 'New Project', 'description' => 'This is a new project'];
        $projectMock = Project::factory()->make(['id' => 1]); 

        $this->projectService->shouldReceive('createProject')
                            ->once()
                            ->with($projectData)
                            ->andReturn($projectMock);

        $response = $this->post('/project/store', $projectData);

        $response->assertRedirect(route('show-project', ['id' => $projectMock->id]));
    }


    public function testShow()
    {
        $projectData = ['id' => 1, 'title' => 'New Project', 'description' => 'This is a new project'];
        $projectMock = Project::factory()->make($projectData);

        $this->projectService->shouldReceive('getProjectById')->once()->with(1)->andReturn($projectMock);

        $response = $this->get("/project/show/1");

        $response->assertStatus(200);
        $response->assertViewIs('project.show');
        $response->assertViewHas('project', $projectMock);
    }

    public function testReorderTasks()
    {
        $projectId = 1;
        $taskIds = [1, 2, 3];

        $this->projectService->shouldReceive('reorderTasks')->once()->with($projectId, $taskIds)->andReturn(true);

        $response = $this->post("/project/{$projectId}/reorderTasks", ['ids' => $taskIds]);

        $response->assertStatus(200);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
