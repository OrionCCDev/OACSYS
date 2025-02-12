<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;

class ProjectEmployeeAssignment extends Component
{
    // use WithPagination;
    public $projectId;
    public $search = '';
    public $selectedEmployeeIds = [];
    public $selectAll = false;
    // public $pageSelected = [];

    // protected $queryString = [
    //     'page' => ['except' => 1, 'as' => 'p'],
    // ];
    protected $paginationTheme = 'bootstrap';

    // public function updatedPage()
    // {
    //     // Keep selections when changing pages
    //     $this->dispatch('pageChanged');
    // }

    public function mount($projectId)
    {
        $this->projectId = $projectId;
    }
    public function updatedSelectedEmployeeIds($value)
    {
        if (in_array($value , $this->selectedEmployeeIds)) {
            array_diff($this->selectedEmployeeIds, array("banana"));

        } else {
            $this->selectedEmployeeIds[] = $value;
        }
        // Reindex array to maintain consecutive keys
        $this->selectedEmployeeIds = array_values($this->selectedEmployeeIds);
        // if (in_array($value , $this->selectedEmployeeIds)) {
        //     $this->selectedEmployeeIds = array_diff($this->selectedEmployeeIds, array("banana"));
        // }else{
        //     $this->selectedEmployeeIds[] = $value;
        // }
        // if (($key = array_search($value, $this->selectedEmployeeIds)) !== false) {
        //     unset($this->selectedEmployeeIds[$key]);
        // } else {
        //     $this->selectedEmployeeIds[] = $value;
        // }
        // // Reindex array to maintain consecutive keys
        // $this->selectedEmployeeIds = array_values($this->selectedEmployeeIds);
    }

    public function render()
    {
        return view('livewire.project-employee-assignment', [
            'employees' => Employee::query()
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('employee_id', 'like', '%' . $this->search . '%');
                    });
                })
                ->get()
        ]);
    }

    public function addToProject()
    {
        $project = Project::findOrFail($this->projectId);

        Employee::whereIn('id', $this->selectedEmployeeIds)
            ->update(['project_id' => $project->id]);

        $this->selectedEmployeeIds = [];
        $this->selectAll = false;
        // $this->pageSelected = [];
        $this->dispatch('alert', message: 'Employees added to project successfully!');
    }
}
