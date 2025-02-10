<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\Position;

class DepartmentPositionSelect extends Component
{
    public $selectedDepartment = '';
    public $selectedPosition = '';
    public $positions = [];
    public $departments;

    public function mount()
    {
        $this->departments = Department::all();
        $this->selectedDepartment = old('department_id');
        $this->selectedPosition = old('position_id');
    }

    public function updatedSelectedDepartment($departmentId)
    {

        if ($departmentId) {
            $this->positions = Position::where('department_id', $departmentId)->get();
        } else {
            $this->positions = [];
        }
        $this->selectedPosition = '';
    }


    public function render()
    {
        return view('livewire.department-position-select');
    }
}
