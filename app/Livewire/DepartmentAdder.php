<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class DepartmentAdder extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    #[Rule('required|min:2|string')]
    public $department_name;
    public $search;

    public $edtId;
    protected $rules = [
        'department_name' => 'required|min:2|unique:departments,name',
        'edtName' => 'required|min:2|unique:departments,name'
    ];

    // Or use custom validation messages
    protected $messages = [
        'department_name.required' => 'Department name is required for new departments',
        'edtName.required' => 'Department name is required when editing'
    ];
    public $edtName;

    public function addNewDepartment()
    {
        $this->validateOnly('department_name');
        Department::create([
            'name' => $this->department_name
        ]);

        $this->reset('department_name');
        $this->resetPage();
        $this->dispatch('showToast');
    }

    public function render()
    {
        $data = Department::latest()->where('name' , 'like' , "%$this->search%")->paginate(8);
        return view('livewire.department-adder' ,compact('data'));
    }

    public function del($id)
    {
        Department::find($id)->delete();
        $this->resetPage();
    }

    public function edt( Department $department)
    {
        $this->edtId = $department->id;
        $this->edtName = $department->name;
    }
    public function cancel()
    {
        $this->reset(['edtId' , 'edtName']);
    }
    public function update( Department $department)
    {
        $this->validateOnly('edtName', [
            'edtName' => 'required|min:2|unique:departments,name,'.$department->id
        ]);
        $department->update([
            'name' => $this->edtName
        ]);

        $this->reset(['edtId' , 'edtName']);

        $this->dispatch('showToastOfUpdate');
    }
}
