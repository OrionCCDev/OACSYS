<?php

namespace App\Livewire;

use Livewire\Component;

class DevicesList extends Component
{
    public $selectedPersonName;
    public $searchOfDevice = '';
    public $devices = [];

    protected $listeners = ['personSelected' => 'updateDevices'];

    public function updateDevices($personName, $devices)
    {
        $this->selectedPersonName = $personName;
        $this->devices = $devices;
    }

    public function render()
    {
        return view('livewire.devices-list');
    }
}
