<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class EmployeeTable extends Component
{
    use WithPagination;
    public $page = 1;

    #[Url(history: true)]
    public $search = '';
    public $departmentFilter = '';
    public $positionFilter = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'departmentFilter' => ['except' => ''],
        'positionFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDepartmentFilter()
    {
        $this->resetPage();
    }

    public function updatingPositionFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'departmentFilter', 'positionFilter', 'statusFilter']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Employee::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('employee_id', 'like', '%' . $this->search . '%');
            })
            ->when($this->departmentFilter !== '', function ($query) {
                $query->where('department_id', $this->departmentFilter);
            })
            ->when($this->positionFilter !== '', function ($query) {
                $query->where('position_id', $this->positionFilter);
            })
            ->when($this->statusFilter === 'active', function ($query) {
                $query->whereNull('resign_date');
            })
            ->when($this->statusFilter === 'resigned', function ($query) {
                $query->whereNotNull('resign_date');
            });

        return view('livewire.employee-table', [
            'employees' => $query->orderBy('updated_at', 'desc')->paginate(10),
            'departments' => Department::orderBy('name')->get(),
            'positions' => Position::orderBy('name')->get(),
        ]);
    }
}
