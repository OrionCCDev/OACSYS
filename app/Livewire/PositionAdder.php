<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Position;
use App\Models\Department;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class PositionAdder extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $defaultPosition = 1;

    #[Rule('required', message: 'Please select a department')]
    public $selectedDepartment = '';

    #[Rule('required|min:3|max:50', message: 'Position name must be unique and between 3-50 characters')]
    public $newPosition = '';



    public function addPosition()
{
    if ($this->selectedDepartment && $this->newPosition) {
        // Validate before creating
    $this->validate();

        // Add position logic here
        Position::create([
            'name' => $this->newPosition,
            'department_id' => $this->selectedDepartment
        ]);

        $this->newPosition = ''; // Clear input after adding
        $this->defaultPosition = $this->selectedDepartment;
        $this->dispatch('positionAdded'); // Emit event to refresh positions list
    }
}


    public function showPositions(Department $department)
    {
        $this->defaultPosition = $department->id;
        $departments = Department::with('positions')->get();
        return view('livewire.position-adder' ,compact('departments'));
    }

    public function render()
    {
        $departments = Department::with('positions')->get();
        return view('livewire.position-adder' ,compact('departments'));
    }


}
