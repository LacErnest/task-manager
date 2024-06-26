<?php

namespace App\Http\Controllers;

use App\Constants\TaskConstants;
use App\Http\Requests\ProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        $projects = $this->projectService->getAllProjects();
        return view('project.index', compact('projects'));
    }

    public function create()
    {
        return view('project.create');
    }

    public function store(ProjectRequest $request)
    {
        $project = $this->projectService->createProject($request->validated());
        return redirect()->route('show-project', ['id' => $project->id]);
    }

    public function show($id)
    {
        $project = $this->projectService->getProjectById($id);
        return view('project.show', compact('project'));
    }

    public function reorderTasks($projectId, Request $request)
    {
        return $this->projectService->reorderTasks($projectId, $request->get('ids'));
    }

    public function listProjectTasks(Request $request)
    {
        $project = $this->projectService->getProjectWithTasks($request->get('selectedProjectId'));
        return view('project.show', [
            'project' => $project,
            'priorities' => TaskConstants::getAllPriorities(),
        ]);
    }
}
