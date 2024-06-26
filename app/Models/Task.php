<?php

namespace App\Models;

use App\Constants\TaskConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'priority', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getPriorityStr()
    {
        $badgeClass = TaskConstants::getPriorityBadge($this->priority);
        return '<span class="' . $badgeClass . '">' . $this->priority . '</span>';
    }

    public function saveValidatedData(array $validated, int $projectId): bool
    {
        $this->fill($validated);
        $this->project_id = $projectId;

        if ($validated['priority'] == TaskConstants::TOP) {
            $this->changeTaskPriorityToTop();
        } else {
            $this->priority = $validated['priority'];
        }

        return $this->save();
    }

    public function changeTaskPriorityToTop(): bool
    {
        $this->shiftPriorities();

        return $this->updatePriority(TaskConstants::TOP);
    }

    private function updatePriority(int $priority): bool
    {
        $this->priority = $priority;
        return $this->saveQuietly();
    }

    private function shiftPriorities(): void
    {
        self::where('project_id', $this->project_id)
            ->orderBy('priority')
            ->get()
            ->each(function ($task) {
                $task->priority++;
                $task->saveQuietly();
            });
    }
}
