<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Device;

class DevicesAssignmentTable extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedDevices = [];
    public $project_id;
    public function render()
    {
        $devices = Device::query()
            ->whereNull('project_id')
            ->whereNull('employee_id')
            ->whereNull('consultant_id')
            ->whereNull('client_id')
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('device_name', 'like', '%' . $this->search . '%')
                      ->orWhere('device_code', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10);

        return view('livewire.devices-assignment-table', [
            'devices' => $devices
        ]);
    }

    public function assignSelected()
    {
        // Add your assignment logic here
        if (count($this->selectedDevices) > 0) {
            Device::whereIn('id', $this->selectedDevices)
                ->update(['project_id' => $this->project_id]); // Add your project ID

            $this->selectedDevices = [];
            session()->flash('success', 'Devices assigned successfully');
            return redirect()->route('project.details', $this->project_id);
        }
    }

    public function cancelSelection()
    {
        $this->selectedDevices = [];
    }
}
