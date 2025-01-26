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

    public function render()
    {
        return view('livewire.device-index', [
            'devices' => Device::where('device_name', 'like', '%'.$this->search.'%')
                        ->orWhere('device_code', 'like', '%'.$this->search.'%')
                        ->paginate(10)
        ]);
    }
}
