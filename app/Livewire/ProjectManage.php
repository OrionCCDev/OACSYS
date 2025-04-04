<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Employee;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class ProjectManage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Form Properties
    #[Rule('required|min:2|max:255|string')]
    public $project_name;
    #[Rule('required|min:2|max:255|string')]
    public $project_code;
    #[Rule('required|numeric|exists:employees,id')]
    public $project_manager;
    #[Rule('required|exists:clients,id')]
    public $client_id;

    // Edit States
    public $editProjectManger = false;
    public $editProjectName = false;
    public $editProjectCode = false;
    public $editProjectClient = false;

    // Edit Properties
    public $project_manager_edited;
    public $edtId;
    public $edtName;
    public $edtedName;
    public $edtedCode;
    public $edtedClient;

    // Search
    public $search = '';

    // Reset all edit states
    private function resetEditStates()
    {
        $this->editProjectManger = false;
        $this->editProjectName = false;
        $this->editProjectCode = false;
        $this->editProjectClient = false;
        $this->edtId = '';
        $this->edtName = '';
        $this->edtedName = '';
        $this->edtedCode = '';
        $this->edtedClient = '';
    }

    public function render()
    {
        return view('livewire.project-manage', [
            'data' => Project::with('manager', 'client')
                ->latest()
                ->where('project_name', 'like', "%{$this->search}%")
                ->paginate(8),
            'managers' => Employee::where('type', 'manager')->orderBy('name', 'asc')->get(),
            'clients' => Client::orderBy('name', 'asc')->get()
        ]);
    }

    public function addNewProject()
    {
        $this->validate();

        Project::create([
            'project_name' => $this->project_name,
            'project_code' => $this->project_code,
            'project_manager_id' => $this->project_manager,
            'client_id' => $this->client_id,
        ]);

        $this->reset();
        $this->dispatch('showToast');
    }

    public function update(Project $project)
    {
        $this->validate([
            'edtedName' => 'required|min:2|max:255|string',
            'edtedClient' => 'required|exists:clients,id'
        ]);

        $project->update([
            'project_name' => $this->edtedName,
            'client_id' => $this->edtedClient
        ]);
        $this->reset(['project_name', 'project_code', 'project_manager', 'client_id']);
        $this->resetEditStates();
    }

    public function updateProjectManager(Project $project)
    {
        $this->validate([
            'project_manager_edited' => 'required|numeric|exists:employees,id'
        ]);

        $project->update(['project_manager_id' => $this->project_manager_edited]);
        $this->resetEditStates();
        $this->dispatch('showToastOfUpdate');
    }

    public function updateProjectCode(Project $project)
    {
        $this->validate([
            'edtedCode' => 'required|min:2|max:255|string'
        ]);

        $project->update(['project_code' => $this->edtedCode]);
        $this->resetEditStates();
        $this->dispatch('showToastOfUpdate');
    }

    public function cancel()
    {
        $this->resetEditStates();
    }

    public function del(Project $project)
    {
        $project->delete();
        $this->dispatch('showToastOfDelete');
    }

    public function edtProjectManager(Project $project)
    {
        $this->edtId = $project->id;
        $this->edtName = $project->project_name;
        $this->editProjectManger = true;
    }

    public function edtProjectName(Project $project)
    {
        $this->edtId = $project->id;
        $this->edtedName = $project->project_name;
        $this->editProjectName = true;
    }

    public function edtProjectCode(Project $project)
    {
        $this->edtId = $project->id;
        $this->edtedCode = $project->project_code;
        $this->editProjectCode = true;
    }

    public function edtProjectClient(Project $project)
    {
        $this->edtId = $project->id;
        $this->edtedClient = $project->client_id;
        $this->editProjectClient = true;
    }
    public function updateProjectClient($projectId)
{
    $project = Project::find($projectId);
    $project->update([
        'client_id' => $this->edtedClient
    ]);

    $this->editProjectClient = false;
    $this->edtId = null;

    $this->dispatch('showToastOfUpdate');
}
}
