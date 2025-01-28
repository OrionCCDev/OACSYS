<?php

namespace App\Livewire;

use App\Models\Device;
use App\Models\SimCard;
use Livewire\Component;
use App\Models\Employee;
use App\Models\Clearance;
use App\Models\Consultant;
use Livewire\WithFileUploads;
use App\Models\ClientEmployee;

class ClearanceDeviceSelector extends Component
{
    use WithFileUploads;

    public $selectedType = '';
    public $selectedEmployee = '';
    public $employees = [];
    public $devices = [];
    public $simCards = [];
    public $selectedItems = [];
    public $clearanceCode;
    public $showPrintArea = false;
    public $signedClearanceFile;
    public $showUploadModal = false;
    public $clearanceId;

    public function mount()
    {
        // Check if there's an existing clearance in progress
        if (session()->has('clearance_in_progress')) {
            $clearanceData = session('clearance_in_progress');
            $this->clearanceId = $clearanceData['id'];
            $this->clearanceCode = $clearanceData['code'];
            $this->selectedType = $clearanceData['type'];
            $this->selectedEmployee = $clearanceData['employee'];
            $this->selectedItems = $clearanceData['items'];
            $this->showPrintArea = true;

            // Load the employee list based on type
            switch ($this->selectedType) {
                case 'employee':
                    $this->employees = Employee::all();
                    $employee = Employee::find($this->selectedEmployee);
                    $this->devices = $employee->devices;
                    $this->simCards = SimCard::where('employee_id', $this->selectedEmployee)->get();
                    break;
                case 'client':
                    $this->employees = ClientEmployee::all();
                    $client = ClientEmployee::find($this->selectedEmployee);
                    $this->devices = $client->devices;
                    $this->simCards = SimCard::where('client_employee_id', $this->selectedEmployee)->get();
                    break;
                case 'consultant':
                    $this->employees = Consultant::all();
                    $consultant = Consultant::find($this->selectedEmployee);
                    $this->devices = $consultant->devices;
                    $this->simCards = SimCard::where('consultant_id', $this->selectedEmployee)->get();
                    break;
            }
        }
    }


    public function addToClearance($type, $id)
    {
        $this->selectedItems[$type][] = $id;
        $this->showPrintArea = true;
    }

    public function createClearance()
    {
        $clearance = Clearance::create([
            'clear_code' => 'CLR-' . time(),
            'status' => 'pending'
        ]);

        if ($this->selectedType == 'client') {
            $clearance->update([
                'client_employee_id' => $this->selectedEmployee
            ]);
            $clearance->save();
        } else {
            $clearance->update([
                $this->selectedType . '_id' => $this->selectedEmployee
            ]);
            $clearance->save();

        }


        $this->clearanceId = $clearance->id;
        $this->clearanceCode = $clearance->clear_code;

        foreach ($this->selectedItems['device'] ?? [] as $deviceId) {
            $clearance->devices()->attach($deviceId);
        }

        foreach ($this->selectedItems['simcard'] ?? [] as $simId) {
            $clearance->simCards()->attach($simId);
        }

        $this->showPrintArea = true;
        // Update the status of all devices to 'pending-cancel'
        $lastclearance = Clearance::with('devices')->find($clearance->id);
        $devices = $lastclearance->devices;
    
        foreach ($devices as $device) {
            $device->update(['status' => 'pending-cancel']);
        }
        // Store clearance data in session
        session(['clearance_in_progress' => [
            'id' => $this->clearanceId,
            'code' => $this->clearanceCode,
            'type' => $this->selectedType,
            'employee' => $this->selectedEmployee,
            'items' => $this->selectedItems
        ]]);
    }

    public function cancelClearance()
    {

        if ($this->clearanceId) {
            $clearance = Clearance::find($this->clearanceId);
            foreach ($clearance->devices as $device) {
                $device->update(['status' => 'taken']);
            }
            // Detach all devices and sim cards first
            $clearance->devices()->detach();
            $clearance->simCards()->detach();
            // Then delete the clearance
            $clearance->delete();
            session()->forget('clearance_in_progress');
            $this->reset(['clearanceId', 'clearanceCode', 'selectedItems', 'showPrintArea']);
        }
    }

    public function uploadSignedClearance()
    {
        $this->validate([
            'signedClearanceFile' => 'required|image|max:2048'
        ]);

        $clearance = Clearance::find($this->clearanceId);

        $filename = $this->clearanceCode . '.' . $this->signedClearanceFile->extension();
        $this->signedClearanceFile->storeAs('public/X-Files/Dash/imgs/clearance', $filename);

        $clearance->update([
            'status' => 'finished',
            'clear_image' => $filename
        ]);

        // Release devices
        foreach ($clearance->devices as $device) {
            $device->update([
                'employee_id' => null,
                'client_id' => null,
                'consultant_id' => null
            ]);
        }

        // Release SIM cards
        foreach ($clearance->simCards as $sim) {
            $sim->update([
                'employee_id' => null,
                'client_employee_id' => null,
                'consultant_id' => null,
                'status' => 'available'
            ]);
        }
        // Clear the session after successful upload
        session()->forget('clearance_in_progress');
        $this->showUploadModal = false;
        return redirect()->route('clearance.index');
    }

    public function updatedSelectedType()
    {
        $this->selectedEmployee = '';
        $this->devices = [];

        switch ($this->selectedType) {
            case 'employee':
                $this->employees = Employee::all();
                break;
            case 'client':
                $this->employees = ClientEmployee::all();
                break;
            case 'consultant':
                $this->employees = Consultant::all();
                break;
        }
    }

    public function updatedSelectedEmployee()
    {
        if ($this->selectedEmployee) {
            switch ($this->selectedType) {
                case 'employee':
                    $employee = Employee::find($this->selectedEmployee);
                    $this->devices = $employee->devices;
                    $this->simCards = SimCard::where('employee_id', $this->selectedEmployee)->get();
                    break;
                case 'client':
                    $client = ClientEmployee::find($this->selectedEmployee);
                    $this->devices = $client->devices;
                    $this->simCards = SimCard::where('client_employee_id', $this->selectedEmployee)->get();
                    break;
                case 'consultant':
                    $consultant = Consultant::find($this->selectedEmployee);
                    $this->devices = $consultant->devices;
                    $this->simCards = SimCard::where('consultant_id', $this->selectedEmployee)->get();
                    break;
            }
        }
    }

    public function render()
    {
        $selectedDevices = [];
        $selectedSimCards = [];

        if (!empty($this->selectedItems['device'])) {
            $selectedDevices = Device::whereIn('id', $this->selectedItems['device'])->get();
        }

        if (!empty($this->selectedItems['simcard'])) {
            $selectedSimCards = SimCard::whereIn('id', $this->selectedItems['simcard'])->get();
        }

        return view('livewire.clearance-device-selector', [
            'selectedDevices' => $selectedDevices,
            'selectedSimCards' => $selectedSimCards
        ]);
    }
}
