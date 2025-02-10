<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\Position;

class DepartmentPositionSelect extends Component
{
    public $selectedDepartment = null;
    public $selectedPosition = null;
    public $positions = [];
    public $departments;
    public $employeedepartment;
    public $employeeposition;

    public function mount()
    {
        // dd($this->employeedepartment , $this->employeeposition);
        $this->departments = Department::all();
        // $this->selectedDepartment = old('department_id');
        // $this->selectedPosition = old('position_id');
        $this->selectedDepartment =  $this->employeedepartment;
        $this->selectedPosition = $this->employeeposition;

        if ($this->selectedDepartment) {
            $this->positions = Position::where('department_id', $this->selectedDepartment)->get();
        }
    }

    public function updatedSelectedDepartment($departmentId)
    {

        if ($departmentId) {
            $this->positions = Position::where('department_id', $departmentId)->get();
        } else {
            $this->positions = [];
        }
        $this->selectedPosition = null;
    }


    public function render()
    {
        return view('livewire.department-position-select');
    }
}
