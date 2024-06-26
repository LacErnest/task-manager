<?php 


namespace App\Repositories;

use App\Models\Task;

interface TaskRepositoryInterface
{
    public function find($id);
    public function create(array $data, $projectId);
    public function update(Task $task, array $data);
    public function delete(Task $task);
    public function reorder(array $tasks);
}