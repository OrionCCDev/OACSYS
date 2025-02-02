<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\Position;
use Livewire\Attributes\On;

class PositionsOfDepartment extends Component
{

    public $departmentId ;
    public $Key;

    public $editablePositionName;
    public $editablePositionId;

    #[On('positionAdded')]
    public function render()
    {
        $departmentPositionsSelected = Department::with('positions')->find($this->departmentId);
        return view('livewire.positions-of-department',compact('departmentPositionsSelected'));
    }

    public function cancel()
    {
        $this->editablePositionName= '';
        $this->editablePositionId= '';

    }

    public function update(Position $position)
    {
        $this->validateOnly('editablePositionName', [
            'editablePositionName' => 'required|min:2'
        ]);
        $position->update([
            'name' => $this->editablePositionName
        ]);

        $this->reset(['editablePositionId' , 'editablePositionName']);


    }

    public function del(Position $position)
    {
        $position->delete();
    }

    public function edt(Position $position)
    {
        $this->editablePositionId = $position->id;
        $this->editablePositionName = $position->name;
    }

}
