<?php

namespace App\Services;

use App\Repositories\ProjectRepositoryInterface;

class ProjectService
{

    protected $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getAllProjects()
    {
        return $this->projectRepository->all();
    }

    public function createProject(array $data)
    {
        return $this->projectRepository->create($data);
    }

    public function getProjectById($id)
    {
        return $this->projectRepository->find($id);
    }

    public function getProjectWithTasks($id)
    {
        return $this->projectRepository->getProjectWithTasks($id);
    }

    public function reorderTasks($projectId, array $taskIds)
    {

        return $this->projectRepository->reorderTasks($projectId, $taskIds);
    }
}
