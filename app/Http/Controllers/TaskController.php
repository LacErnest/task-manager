<?php

namespace App\Http\Controllers;

use App\Constants\TaskConstants;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function create($projectId)
    {
        $priorities = TaskConstants::getAllPriorities();
        return view('task.create', compact('priorities', 'projectId'));
    }

    public function store(TaskRequest $request, $projectId)
    {
        $attributes = $request->validated();
        $this->taskService->createTask($attributes, $projectId);
        return redirect()->route('show-project', ['id' => $projectId]);
    }

    public function edit($projectId, $id)
    {
        $task = $this->taskService->getTaskById($id);
        $priorities = TaskConstants::getAllPriorities();
        return view('task.update', compact('task', 'projectId', 'priorities'));
    }

    public function update(TaskRequest $request, $projectId, $id)
    {
        $attributes = $request->validated();
        $this->taskService->updateTask($attributes, $projectId, $id);
        return redirect()->route('show-project', ['id' => $projectId]);
    }

    public function destroy($id)
    {   
        $task = $this->taskService->getTaskById($id);
        $projectId = $task->project_id;
        $this->taskService->deleteTask($id);
        $this->reorderPriorities($projectId);
        return redirect()->route('show-project',['id' => $projectId]);
    }

    private function reorderPriorities(int $projectId): void
    {   
        $tasks = Task::where('project_id', $projectId)
            ->orderBy('priority')
            ->get();
        
        foreach ($tasks as $index => $task) {
            $task->priority = $index + 1;
            $task->saveQuietly();
        }
    }
}
