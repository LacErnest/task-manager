<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $taskService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskService = Mockery::mock(TaskService::class);
        $this->app->instance(TaskService::class, $this->taskService);
    }

    public function testCreate()
    {
        $projectId = 1;
        $this->get("/project/{$projectId}/task/create")
             ->assertStatus(Response::HTTP_OK)
             ->assertViewIs('task.create')
             ->assertViewHasAll(['priorities', 'projectId']);
    }

    public function testStore()
    {
        $projectId = 1;
        $taskData = ['name' => 'New Task', 'priority' => 1];
        
        $this->taskService->shouldReceive('createTask')->once()->with($taskData, $projectId);

        $this->post("/project/{$projectId}/task/store", $taskData)
             ->assertRedirect(route('show-project', ['id' => $projectId]));
    }

    public function testEdit()
    {
        $projectId = 1;
        $taskId = 1;
        $taskMock = new Task(['id' => $taskId, 'name' => 'Sample Task']);

        $this->taskService->shouldReceive('getTaskById')->once()->with($taskId)->andReturn($taskMock);

        $this->get("/project/{$projectId}/task/{$taskId}/edit")
             ->assertStatus(Response::HTTP_OK)
             ->assertViewIs('task.update')
             ->assertViewHasAll(['task', 'projectId', 'priorities']);
    }

    public function testUpdate()
    {
        $projectId = 1;
        $taskId = 1;
        $taskData = ['name' => 'Updated Task', 'priority' => 2];

        $this->taskService->shouldReceive('updateTask')->once()->with($taskData, $projectId, $taskId);

        $this->put("/project/{$projectId}/task/{$taskId}/update", $taskData)
             ->assertRedirect(route('show-project', ['id' => $projectId]));
    }

    public function testDestroy()
    {
        $taskId = 1;
        $projectId = 1;

        $taskMock = new Task(['id' => $taskId, 'project_id' => $projectId]);

        $this->taskService->shouldReceive('getTaskById')->once()->with($taskId)->andReturn($taskMock);
        $this->taskService->shouldReceive('deleteTask')->once()->with($taskId);

        $response = $this->delete("/project/task/{$taskId}/delete");

        $response->assertRedirect(route('show-project', ['id' => $projectId]));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
