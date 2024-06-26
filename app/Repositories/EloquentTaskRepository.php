<?php

namespace App\Repositories;

use App\Models\Task;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    public function all()
    {
    }

    public function find($id)
    {
        return Task::where('id', $id)->first();
    }

    public function create(array $data, $projectId)
    {
        $task = new Task();
        $task->saveValidatedData($data, $projectId);
        return $task;
    }

    public function update(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task)
    {
        return $task->delete();
    }

    public function reorder(array $tasks)
    {
        foreach ($tasks as $priority => $id) {
            Task::where('id', $id)->update(['priority' => $priority + 1]);
        }
    }
}

