<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Device;
use Livewire\WithPagination;

class DeviceIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function del($deviceId)
    {
        $device = Device::find($deviceId);
        if ($device) {
            $device->delete();
            // No need to refresh the devices list manually, it will be handled by the render method
        }
    }

    public function render()
    {
        $devices = Device::where(function($query) {
                            $query->where('device_name', 'like', '%'.$this->search.'%')
                                  ->orWhere('device_code', 'like', '%'.$this->search.'%');
                        })
                        ->orderByRaw("CASE WHEN status = 'available' THEN 0 ELSE 1 END")
                        ->orderBy('updated_at', 'desc')
                        ->paginate(10);

        return view('livewire.device-index', [
            'devices' => $devices,
        ]);
    }
}
