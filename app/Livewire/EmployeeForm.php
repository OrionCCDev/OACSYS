<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\Position;

class EmployeeForm extends Component
{
    public $selectedDepartment = '';
    public $positions = [];
    public $departments;
    public $selectedPosition = '';

    public function mount()
    {
        $this->departments = Department::all();
    }

    public function updatedSelectedDepartment($department_id)
    {
        if ($department_id) {
            $this->positions = Position::where('department_id', $department_id)->get();
        } else {
            $this->positions = [];
        }
        $this->selectedPosition = '';
    }

    public function render()
    {
        return view('livewire.employee-form');
    }
}
