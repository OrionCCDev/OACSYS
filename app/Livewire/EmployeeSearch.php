<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Livewire\Attributes\Url;

class EmployeeSearch extends Component
{
    #[Url]
    public $search = '';

    public $selectedEmployee = null;
    public $deviceId;

    public function mount($deviceId)
    {
        $this->deviceId = $deviceId;
    }

    public function updatedSearch()
    {
        $this->reset('selectedEmployee');
    }

    public function selectEmployee($employeeId)
    {
        $this->selectedEmployee = $employeeId;
    }

    public function assignDevice()
    {
        if (!$this->selectedEmployee) {
            $this->addError('employee', 'Please select an employee');
            return;
        }

        $device = \App\Models\Device::find($this->deviceId);
        if ($device) {
            $device->update([
                'status' => 'taken',
                'employee_id' => $this->selectedEmployee,
                'client_id' => null,
                'consultant_id' => null,
                'project_id' => null
            ]);

            $this->dispatch('close-modal');
            $this->redirect(route('device.show', $device->id));
        }
    }

    public function render()
    {
        $employees = [];

        if (strlen($this->search) >= 2) {
            $employees = Employee::where('employee_id', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%')
                ->select('id', 'name', 'employee_id')
                ->limit(10)
                ->get();
        }

        return view('livewire.employee-search', [
            'employees' => $employees
        ]);
    }
}
