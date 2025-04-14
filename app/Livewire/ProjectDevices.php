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
            // Check if device exists
            $device = Device::findOrFail($deviceId);

            // Check if device is already in project with any status
            $existingDevice = ProjectDevice::where('project_id', $this->project->id)
                                ->where('device_id', $deviceId)
                                ->first();

            // First, create or update the ProjectDevice relationship
            if ($existingDevice) {
                // If device exists but not in pending status, update its status
                if ($existingDevice->status !== 'pending-project-device') {
                    $existingDevice->status = 'pending-project-device';
                    $existingDevice->save();
                    $this->dispatch('showToastUpdate');
                } else {
                    $this->dispatch('showToastError', ['message' => 'Device already assigned to this project with pending status']);
                    return; // Exit early if already in pending status
                }
            } else {
                // Add new device to project
                ProjectDevice::create([
                    'project_id' => $this->project->id,
                    'device_id' => $deviceId,
                    'status' => 'pending-project-device'
                ]);
                $this->dispatch('showToastAdd');
            }

            // Now try multiple ways to update the Device record
            try {
                // Method 1: Direct property assignment
                $updatedDevice = Device::find($deviceId); // Re-fetch to avoid any cache issues
                $updatedDevice->status = 'pending-project-device';
                $updatedDevice->project_id = $this->project->id;
                $result = $updatedDevice->save();

                if (!$result) {
                    // Method 2: Try using update if method 1 fails
                    $updateResult = Device::where('id', $deviceId)
                        ->update([
                            'status' => 'pending-project-device',
                            'project_id' => $this->project->id
                        ]);

                    if (!$updateResult) {
                        // Method 3: Use DB facade directly
                        \DB::table('devices')
                            ->where('id', $deviceId)
                            ->update([
                                'status' => 'pending-project-device',
                                'project_id' => $this->project->id
                            ]);
                    }
                }

                // Add success message for device update
                $this->dispatch('showToastDeviceUpdated');
            } catch (\Exception $deviceUpdateError) {
                // Log specific device update error
                $this->dispatch('showToastError', ['message' => 'Error updating device: ' . $deviceUpdateError->getMessage()]);
            }

            // Refresh the devices list
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
