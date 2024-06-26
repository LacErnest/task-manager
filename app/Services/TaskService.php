<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;

class TaskService
{

    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function createTask(array $data, $projectId)
    {
        return $this->taskRepository->create($data, $projectId);
    }

    public function getTaskById($id)
    {
        return $this->taskRepository->find($id);
    }

    public function updateTask(array $data, $projectId, $id)
    {
        $data['project_id'] = $projectId;
        $task = $this->getTaskById($id);
        return $this->taskRepository->update($task, $data);
    }

    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }

}
