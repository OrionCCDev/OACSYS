<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectAssetsIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $statusFilter = 'all';

    public function render()
    {
        $query = Project::with(['devices', 'simCards', 'manager', 'client'])
            ->where('project_name', 'like', "%{$this->search}%");

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $projects = $query->latest()->paginate(10);

        // Calculate asset counts for each project
        foreach ($projects as $project) {
            $project->devices_count = $project->devices()->count();
            $project->sim_cards_count = $project->simCards()->count();
            $project->total_assets_count = $project->devices_count + $project->sim_cards_count;
        }

        return view('livewire.project-assets-index', [
            'projects' => $projects
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
}
