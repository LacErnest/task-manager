<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Task;

class EloquentProjectRepository implements ProjectRepositoryInterface
{
    public function all()
    {
        return Project::all();
    }

    public function find($id)
    {
        return Project::where('id', $id)->first();
    }

    public function create(array $data)
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data)
    {
        return $project->update($data);
    }

    public function delete(Project $project)
    {
        return $project->delete();
    }

    public function getProjectWithTasks($id) {
        return Project::with(['tasks' => function ($query) {
            $query->orderBy('priority', 'asc');
        }])->findOrFail($id);
    }

    public function reorderTasks($projectId, array $taskIds)
    {
        foreach ($taskIds as $priority => $id) {
            Task::where('id', $id)->update(['priority' => $priority + 1]);
        }
        return Project::with(['tasks' => function ($query) {
            $query->orderBy('priority', 'asc');
        }])->findOrFail($projectId);
    }
}

