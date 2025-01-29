<?php

namespace App\Livewire;

use App\Models\Device;
use App\Models\Receive;
use App\Models\SimCard;
use Livewire\Component;
use App\Models\Employee;
use App\Models\Consultant;
use Livewire\WithPagination;
use App\Models\ClientEmployee;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ReceiverTypeSelect extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $selectedType = 'employee';
    public $selectedPerson = null;
    public $continueReceiveDeviceId = null;
    public $selectedPersonName = null;
    public $receivers = [];
    public $personDevices = [];
    public $selectedDevices = [];
    public $simcardsPage = 1;
    public $simcards = [];
    public $selectedSimcards = [];
    public $selectedSimcardsDetails = [];
    public $searchOfSim = '';
    public $searchEmployeeId = '';
    public function mount()
    {
        $this->selectedType = request()->query('type', 'employee');
        $this->selectedPerson = request()->query('person');
        $this->searchOfDevice = request()->query('deviceCode', '');
        $this->continueReceiveDeviceId = request()->query('continueReceiveDeviceId', '');

        $this->simcards = SimCard::where('status', 'available')->get();
        $this->loadSimcards();
        if ($this->continueReceiveDeviceId) {
            $device = Device::find($this->continueReceiveDeviceId);
            if ($device) {
                // First set the type
                if ($device->employee_id) {
                    $this->selectedType = 'employee';
                    $tempPerson = $device->employee_id;
                } elseif ($device->client_id) {
                    $this->selectedType = 'client';
                    $tempPerson = $device->client_id;
                } elseif ($device->consultant_id) {
                    $this->selectedType = 'consultant';
                    $tempPerson = $device->consultant_id;
                }

                // Update receivers list first
                $this->updateReceivers();

                // Then set the person
                $this->selectedPerson = $tempPerson;
                // Finally trigger the person selection
                $this->updatedSelectedPerson();
            }
        } else {
            $this->updateReceivers();
        }
    }
    public function getSimcardsProperty()
    {
        return Simcard::where('status', 'available')
            ->when($this->searchOfDevice, function ($query) {
                $query->where('sim_number', 'like', '%' . $this->searchOfDevice . '%');
            })
            ->paginate(10, ['*'], 'simcardsPage', $this->simcardsPage);
    }
    public function selectEmployeeBySearch()
    {
        $employee = Employee::where('employee_id', $this->searchEmployeeId)->first();
        if ($employee) {
            $this->selectedPerson = $employee->id;
        }
    }
    public function updateSearchInput()
{
    if ($this->selectedPerson) {
        $employee = Employee::find($this->selectedPerson);
        $this->searchEmployeeId = $employee->employee_id;
    }
}

public function getSelectedEmployeeId()
{
    return Employee::find($this->selectedPerson)?->employee_id;
}
    public function loadSimcards()
    {
        $this->simcards = Simcard::where('status', 'available')
            ->when($this->searchOfDevice, function ($query) {
                $query->where('sim_number', 'like', '%' . $this->searchOfDevice . '%');
            })
            ->paginate(10)
            ->items();
    }

    public function removeFromSelectedSimcards($simId)
    {
        $this->selectedSimcards = array_diff($this->selectedSimcards, [$simId]);
        $this->selectedSimcardsDetails = Simcard::whereIn('id', $this->selectedSimcards)->get();
    }
    public function removeSimFromSelection($simId)
    {
        $sim = SimCard::find($simId);
        if ($sim) {
            $sim->update([
                'employee_id' => null,
                'client_employee_id' => null,
                'consultant_id' => null,
                'status' => 'available'
            ]);
            $this->loadSimcards();
        }
    }
    public function getSelectedSimCardsProperty()
    {
        if (!$this->selectedPerson) {
            return collect();
        }
        if ($this->selectedType === 'employee') {
            return SimCard::where('employee_id', $this->selectedPerson)
                ->where('status', 'taken')
                ->get();
        } elseif ($this->selectedType === 'client') {
            return SimCard::where('client_employee_id', $this->selectedPerson)
                ->where('status', 'taken')
                ->get();
        } elseif ($this->selectedType === 'consultant') {
            return SimCard::where('consultant_id', $this->selectedPerson)
                ->where('status', 'taken')
                ->get();
        }
    }
    public function addSimToSelection($simId)
    {
        // $sim = SimCard::find($simId);
        // if ($sim && $this->selectedPerson) {
        //     $this->selectedSimcards[] = $simId;
        //     if($this->selectedType == 'employee') {
        //         $sim->update([
        //             'employee_id' => $this->selectedPerson,
        //             'status' => 'taken'
        //         ]);
        //     }elseif($this->selectedType == 'client') {
        //         $sim->update([
        //             'client_employee_id' => $this->selectedPerson,
        //             'status' => 'taken'
        //         ]);
        //     }elseif($this->selectedType == 'consultant') {
        //         $sim->update([
        //             'consultant_id' => $this->selectedPerson,
        //             'status' => 'taken'
        //         ]);
        //     }

        //     $this->loadSimcards(); // Refresh the simcards list
        // }
        $sim = SimCard::find($simId);
        if ($sim && $this->selectedPerson) {
            // Ensure we don't add duplicates
            if (!in_array($simId, $this->selectedSimcards)) {
                $this->selectedSimcards[] = $simId;
            }

            // Update sim status based on receiver type
            $updateData = [
                'status' => 'taken'
            ];

            switch ($this->selectedType) {
                case 'employee':
                    $updateData['employee_id'] = $this->selectedPerson;
                    break;
                case 'client':
                    $updateData['client_employee_id'] = $this->selectedPerson;
                    break;
                case 'consultant':
                    $updateData['consultant_id'] = $this->selectedPerson;
                    break;
            }

            $sim->update($updateData);
            $this->loadSimcards();
        }
    }

    public function getReceives()
    {
        if ($this->selectedType === 'employee') {
            $receiver = Employee::find($this->selectedPerson);
        } elseif ($this->selectedType === 'client') {
            $receiver = ClientEmployee::find($this->selectedPerson);
        } elseif ($this->selectedType === 'consultant') {
            $receiver = Consultant::find($this->selectedPerson);
        }

        return $receiver ? $receiver->receives : collect();
    }
    public function addDeviceToSelection($deviceId)
    {

        if (!$this->selectedPerson) {
            return;
        }

        if (!in_array($deviceId, $this->selectedDevices)) {

            $this->selectedDevices[] = $deviceId;
            $device = Device::find($deviceId);
            $device->status = 'pending-receiving';

            switch ($this->selectedType) {
                case 'client':
                    $device->client_id = $this->selectedPerson;
                    break;
                case 'consultant':
                    $device->consultant_id = $this->selectedPerson;
                    break;
                case 'employee':
                    $device->employee_id = $this->selectedPerson;
                    break;
            }

            $device->save();
            $this->dispatch('deviceAdded');
        }
    }
    public function cancelReceiving($receiveId)
    {
        // Get the receive record
        $receive = Receive::find($receiveId);

        // Update all devices linked to this receive
        Device::where('receive_id', $receiveId)
            ->update([
                'status' => 'available',
                'receive_id' => null
            ]);

        // Delete the receive record
        $receive->delete();

        // Optional: Add a success notification
        session()->flash('message', 'Receiving cancelled successfully');
    }
    public function removeFromPersonDevices($deviceId)
    {
        // Find the device
        $device = Device::find($deviceId);

        // Reset status and IDs
        $device->status = 'available';
        $device->client_id = null;
        $device->consultant_id = null;
        $device->employee_id = null;
        $device->save();

        // Remove from personDevices collection
        $this->personDevices = $this->personDevices->filter(function ($device) use ($deviceId) {
            return $device->id !== $deviceId;
        });

        // Remove from selectedDevices array
        $this->selectedDevices = array_diff($this->selectedDevices, [$deviceId]);

        // Emit event for frontend updates
        $this->dispatch('deviceRemoved');
        // // Remove from personDevices collection
        // $this->personDevices = $this->personDevices->filter(function($device) use ($deviceId) {
        //     return $device->id !== $deviceId;
        // });

        // // Also remove from selectedDevices array if present
        // $this->selectedDevices = array_diff($this->selectedDevices, [$deviceId]);

        // // Emit event for frontend updates
        // $this->dispatch('deviceRemoved');
    }

    public function getSelectedDevicesDetailsProperty()
    {
        return Device::whereIn('id', $this->selectedDevices)->get();
    }

    public function updatedSelectedType()
    {
        $this->updateUrlParameters();
        $this->updateReceivers();
    }
    private function updateUrlParameters()
    {
        $this->dispatch('urlChanged', [
            'type' => $this->selectedType,
            'person' => $this->selectedPerson
        ]);
    }
    public function updatedSelectedPerson()
    {
                // Clear all selections when changing receiver
        $this->selectedDevices = [];
        $this->selectedSimcards = [];
        $this->selectedSimcardsDetails = [];

        $this->updateUrlParameters();

        $selectedReceiver = $this->receivers->where('id', $this->selectedPerson)->first();
        $this->personDevices = $selectedReceiver?->devices ?? [];
        $this->selectedPersonName = $selectedReceiver?->name;

        // Reset simcards list to show only available ones
        $this->loadSimcards();
    }

    public function updateReceivers()
    {
        $this->selectedPerson = '';
        $this->selectedPersonName = null;
        $this->personDevices = collect([]);
        $this->selectedDevices = []; // Add this line to clear selected devices
        $this->receivers = match ($this->selectedType) {
            'employee' => Employee::with(['devices.receive'])->orderBy('name', 'asc')->get(),
            'client' => ClientEmployee::with(['devices.receive'])->orderBy('name', 'asc')->get(),
            'consultant' => Consultant::with(['devices.receive'])->orderBy('name', 'asc')->get(),
            default => [],
        };
    }

    public $searchOfDevice = '';

    public function updatedSearchOfDevice()
    {
        // No need to assign the result to a variable since we'll use it in render()
        $this->resetPage(); // Reset pagination when searching
    }

    public function makeReceiving()
    {
        $devices = implode(',', $this->selectedDevices);
        $receiverId = $this->selectedPerson;
        $receiverType = $this->selectedType;


        $recv = Receive::create([
            'status' => 'pending',
            'client_employee_id' => $this->selectedType === 'client' ? $this->selectedPerson : null,
            'employee_id' => $this->selectedType === 'employee' ? $this->selectedPerson : null,
            'consultant_id' => $this->selectedType === 'consultant' ? $this->selectedPerson : null,
        ]);

        if ($this->selectedDevices) {
            foreach ($this->selectedDevices as $deviceId) {
                DB::table('device_and_sim_receives')->insert(
                    [
                        'receive_id' => $recv->id,
                        'device_id' => $deviceId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }



        // dd($this->selectedSimcards);
        if (is_array($this->selectedSimcards) && !empty($this->selectedSimcards)) {
            foreach ($this->selectedSimcards as $simId) {
                $updateData = ['status' => 'pending-receive'];

                switch ($this->selectedType) {
                    case 'employee':
                        $updateData['employee_id'] = $this->selectedPerson;
                        break;
                    case 'client':
                        $updateData['client_employee_id'] = $this->selectedPerson;
                        break;
                    case 'consultant':
                        $updateData['consultant_id'] = $this->selectedPerson;
                        break;
                }

                SimCard::where('id', $simId)->update($updateData);
                DB::table('device_and_sim_receives')->insert(
                    [
                        'receive_id' => $recv->id,
                        'sim_card_id' => $simId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
        // Set status as pending for selected devices
        foreach ($this->selectedDevices as $deviceId) {
            Device::where('id', $deviceId)->update(['status' => 'pending-receiving']);
        }
        // dd($this->selectedSimcards);
        return redirect()->route('receive.make', [
            'receive_id' => $recv->code,
            'rcv_id' => $recv->id,
            'devices' => $devices,
            'receiver_id' => $receiverId,
            'receiver_type' => $receiverType,
            'simCards' => !empty($this->selectedSimcards) ? implode(',', $this->selectedSimcards) : 'none'
        ]);
    }
    public function getSimCards()
    {
        return SimCard::where('status', 'available')
            ->when($this->searchOfSim, function ($query) {
                return $query->where('sim_number', 'like', '%' . $this->searchOfSim . '%');
            })
            ->paginate(10);
    }
    public function render()
    {
        // return view('livewire.receiver-type-select', [
        //     'devices' => Device::where('status','available')->paginate(2)
        // ]);
        return view('livewire.receiver-type-select', [
            'devices' => Device::where('status', 'available')
                ->where(function ($query) {
                    $query->where('device_code', 'like', '%' . $this->searchOfDevice . '%')
                        ->orWhere('device_name', 'like', '%' . $this->searchOfDevice . '%')
                        ->orWhere('serial_number', 'like', '%' . $this->searchOfDevice . '%');
                })
                ->paginate(10),
            'simcards' => $this->simcards
        ]);
    }
}
