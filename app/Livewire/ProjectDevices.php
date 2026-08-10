<?php

namespace App\Livewire;

use DB;
use App\Models\Device;
use App\Models\Project;
use Livewire\Component;
use App\Models\ProjectDevice;

class ProjectDevices extends Component
{
    public $project;
    public $devices;
    public $newDeviceId;

    public function mount($projectId)
    {
        $this->project = Project::find($projectId);
        $this->loadDevices();
    }

    public function loadDevices()
    {
        // Load all devices with pending-project-device status for this project
        // Using with('device') for eager loading to prevent N+1 query issues
        $this->devices = Device::where('project_id', $this->project->id)
                            ->where('status', 'pending-project-device')
                            ->get();
    }

    public function cancelDevice($deviceId)
    {
        $projectDevice = ProjectDevice::where('project_id', $this->project->id)
                            ->where('device_id', $deviceId)
                            ->where('status', 'pending-project-device')
                            ->first();

        if ($projectDevice) {
            $projectDevice->delete();
            Device::where('id', $deviceId)
                ->update(['status' => 'available', 'project_id' => null]);

            $this->dispatch('showToastCancel');
            $this->loadDevices();
        }
    }

    public function addDevice()
    {
        $this->validate([
            'newDeviceId' => 'required|exists:devices,id'
        ], [
            'newDeviceId.required' => 'Please select a device',
            'newDeviceId.exists' => 'Selected device does not exist'
        ]);

        // Check if device is already in project
        $exists = ProjectDevice::where('project_id', $this->project->id)
                    ->where('device_id', $this->newDeviceId)
                    ->exists();

        if ($exists) {
            $this->addError('newDeviceId', 'This device is already assigned to this project');
            return;
        }

        // Add new device to project
        ProjectDevice::create([
            'project_id' => $this->project->id,
            'device_id' => $this->newDeviceId,
            'status' => 'pending-project-device'
        ]);

        $this->dispatch('showToastAdd');
        $this->reset('newDeviceId');
        $this->loadDevices();
    }

    public function getAvailableDevicesProperty()
    {
        // Get all devices that are available and not assigned to any project or person
        return Device::where('status', 'available')
                ->whereNull('project_id')
                ->whereNull('client_id')
                ->whereNull('consultant_id')
                ->whereNull('employee_id')
                ->orderBy('device_name')
                ->get();
    }

    public function addDeviceDirectly($deviceId)
    {
        try {
            $device = Device::findOrFail($deviceId);

            // Refuse to grab a device that's currently assigned to someone/something else -
            // this used to skip that check entirely and could silently hijack a device away
            // from whoever/whatever already had it.
            $ownedElsewhere = $device->status !== 'available'
                || $device->employee_id !== null
                || $device->client_id !== null
                || $device->consultant_id !== null
                || ($device->project_id !== null && (int) $device->project_id !== (int) $this->project->id);

            if ($ownedElsewhere) {
                $this->dispatch('showToastError', ['message' => 'Device is already assigned elsewhere and cannot be added directly.']);
                return;
            }

            $existingDevice = ProjectDevice::where('project_id', $this->project->id)
                                ->where('device_id', $deviceId)
                                ->first();

            if ($existingDevice) {
                if ($existingDevice->status === 'pending-project-device') {
                    $this->dispatch('showToastError', ['message' => 'Device already assigned to this project with pending status']);
                    return;
                }
                $existingDevice->status = 'pending-project-device';
                $existingDevice->save();
                $this->dispatch('showToastUpdate');
            } else {
                ProjectDevice::create([
                    'project_id' => $this->project->id,
                    'device_id' => $deviceId,
                    'status' => 'pending-project-device'
                ]);
                $this->dispatch('showToastAdd');
            }

            $device->update([
                'status' => 'pending-project-device',
                'project_id' => $this->project->id,
            ]);
            $this->dispatch('showToastDeviceUpdated');

            $this->loadDevices();
        } catch (\Exception $e) {
            $this->dispatch('showToastError', ['message' => 'Error in process: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.project-devices');
    }
}
