<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Device;
use App\Models\Deduction;

class EmployeeDeduction extends Component
{
    public $employee;
    public $selectedDevice = '';
    public $reason = '';
    public $description = '';
    public $amount = 0;
    public $assignedDevices = [];
    public $showDeductionForm = false;

    public function mount($employeeId)
    {
        $this->employee = Employee::with(['department', 'position'])->findOrFail($employeeId);
        $this->assignedDevices = Device::where('employee_id', $employeeId)->get();
    }

    public function saveDeduction()
    {
        $this->validate([
            'selectedDevice' => 'nullable',
            'reason' => 'required',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|min:10'
        ]);

        Deduction::create([
            'employee_id' => $this->employee->id,
            'device_id' => $this->selectedDevice ?? null,
            'reason' => $this->reason,
            'amount' => $this->amount,
            'description' => $this->description
        ]);

        session()->flash('message', 'Deduction created successfully!');
        $this->reset(['selectedDevice', 'reason', 'amount', 'description']);
        $this->showDeductionForm = false;
        return redirect()->route('deduction.showEmployeeDeduction', $this->employee->id);
    }

    public function printDeduction()
    {
        return response()->view('deductions.print', [
            'employee' => $this->employee,
            'device' => Device::find($this->selectedDevice),
            'reason' => $this->reason,
            'amount' => $this->amount,
            'description' => $this->description,
            'date' => date('Y-m-d')
        ]);
    }

    public function render()
    {
        return view('livewire.employee-deduction');
    }
}
