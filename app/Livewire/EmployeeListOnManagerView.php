<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;

class EmployeeListOnManagerView extends Component
{
    use WithPagination;

    public $search = '';
    public $managerId;

    public function mount($managerId)
    {
        $this->managerId = $managerId;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $employees = Employee::where('manager_id', $this->managerId)
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('employee_id', 'like', '%' . $this->search . '%');
            })
            ->with(['position', 'department'])
            ->paginate(10);

        return view('livewire.employee-list-on-manager-view', [
            'employees' => $employees
        ]);
    }
}
