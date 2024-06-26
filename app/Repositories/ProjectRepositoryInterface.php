<?php

namespace App\Repositories;

use App\Models\Project;

interface ProjectRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(Project $project, array $data);
    public function delete(Project $project);
    public function getProjectWithTasks($id);
    public function reorderTasks($projectId, array $taskIds);
}