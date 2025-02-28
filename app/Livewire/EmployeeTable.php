<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class EmployeeTable extends Component
{
    use WithPagination;
    public $page = 1;

    #[Url(history: true)]
    public $search = '';
    public $positionFilter = '';

    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'positionFilter',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];



    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {

        $query = Employee::query()
        ->when($this->search, function($query) {
            $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('employee_id', 'like', '%'.$this->search.'%');
        })
        ->when($this->positionFilter === 'manager', function($query) {
            $query->whereHas('position', function($q) {
                $q->where('name', 'like', '%manager%');
            });
        });

            return view('livewire.employee-table', [
                'employees' => $query->orderBy('updated_at', 'desc')->paginate(10)
            ]);

        // if($this->search != ''){
        //     $employees = Employee::query()
        //         ->where(function ($query) {
        //             $query->where('name', 'like', '%' . $this->search . '%')
        //                 ->orWhere('employee_id', 'like', '%' . $this->search . '%');
        //         })
        //         ->orderBy('updated_at', 'desc')
        //         ->paginate(10);}else{
        //     $employees = Employee::query()->orderBy('updated_at', 'desc')
        //     ->paginate(10);
        // }



        // return view('livewire.employee-table', [
        //     'employees' => $employees,
        // ]);
    }
}
