<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Department;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class DepartmentAdder extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    #[Rule('required|min:2|string')]
    public $department_name;
    public $department_manager;
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
    public $edtManager;

    public function addNewDepartment()
    {
        $this->validateOnly('department_name');
        Department::create([
            'name' => $this->department_name,
            'department_manager_id' => $this->department_manager ?: null,
        ]);

        $this->reset(['department_name', 'department_manager']);
        $this->resetPage();
        $this->dispatch('showToast');
    }

    public function render()
    {
        $data = Department::latest()->where('name' , 'like' , "%$this->search%")->paginate(8);
        $managers = Employee::where('type', 'manager')->orderBy('name', 'asc')->get();
        return view('livewire.department-adder' ,compact('data', 'managers'));
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
        $this->edtManager = $department->department_manager_id;
    }
    public function cancel()
    {
        $this->reset(['edtId' , 'edtName', 'edtManager']);
    }
    public function update( Department $department)
    {
        $this->validateOnly('edtName', [
            'edtName' => 'required|min:2|unique:departments,name,'.$department->id
        ]);
        $department->update([
            'name' => $this->edtName,
            'department_manager_id' => $this->edtManager ?: null,
        ]);

        $this->reset(['edtId' , 'edtName', 'edtManager']);

        $this->dispatch('showToastOfUpdate');
    }
}
