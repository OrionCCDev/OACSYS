<?php

namespace App\Livewire;

use App\Models\Clearance;
use App\Models\Device;
use App\Models\DeviceAndSimReceive;
use App\Models\Employee;
use App\Models\Receive;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DeviceTransferPicker extends Component
{
    public $fromSearch = '';
    public $toSearch = '';
    public $fromEmployeeId = null;
    public $toEmployeeId = null;
    public $selectedDevices = [];
    public $deviceNotes = [];

    public function updatedFromSearch()
    {
        $this->fromEmployeeId = null;
        $this->selectedDevices = [];
    }

    public function updatedToSearch()
    {
        $this->toEmployeeId = null;
    }

    public function selectFromEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        $this->fromEmployeeId = $employee->id;
        $this->fromSearch = $employee->name . ' (' . $employee->employee_id . ')';
        $this->selectedDevices = [];
    }

    public function selectToEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        $this->toEmployeeId = $employee->id;
        $this->toSearch = $employee->name . ' (' . $employee->employee_id . ')';
    }

    public function clearFrom()
    {
        $this->reset(['fromEmployeeId', 'fromSearch', 'selectedDevices']);
    }

    public function clearTo()
    {
        $this->reset(['toEmployeeId', 'toSearch']);
    }

    public function getFromResultsProperty()
    {
        if ($this->fromEmployeeId || strlen($this->fromSearch) < 2) {
            return collect();
        }

        return Employee::where('employee_id', 'like', "%{$this->fromSearch}%")
            ->orWhere('name', 'like', "%{$this->fromSearch}%")
            ->limit(10)->get();
    }

    public function getToResultsProperty()
    {
        if ($this->toEmployeeId || strlen($this->toSearch) < 2) {
            return collect();
        }

        return Employee::where(function ($q) {
                $q->where('employee_id', 'like', "%{$this->toSearch}%")
                    ->orWhere('name', 'like', "%{$this->toSearch}%");
            })
            ->when($this->fromEmployeeId, fn ($q) => $q->where('id', '!=', $this->fromEmployeeId))
            ->limit(10)->get();
    }

    public function getFromDevicesProperty()
    {
        if (!$this->fromEmployeeId) {
            return collect();
        }

        return Device::where('employee_id', $this->fromEmployeeId)->where('status', 'taken')->get();
    }

    public function submit()
    {
        $this->validate([
            'fromEmployeeId' => 'required|exists:employees,id|different:toEmployeeId',
            'toEmployeeId' => 'required|exists:employees,id',
            'selectedDevices' => 'required|array|min:1',
            'selectedDevices.*' => 'exists:devices,id',
        ], [
            'fromEmployeeId.different' => 'Choose two different employees.',
            'selectedDevices.required' => 'Select at least one device to transfer.',
        ]);

        $result = DB::transaction(function () {
            // Only devices actually currently held by the "from" employee - a stale
            // selection (someone else already moved it) shouldn't silently transfer it.
            $deviceIds = Device::where('employee_id', $this->fromEmployeeId)
                ->where('status', 'taken')
                ->whereIn('id', $this->selectedDevices)
                ->pluck('id');

            if ($deviceIds->isEmpty()) {
                return null;
            }

            $clearance = Clearance::create([
                'employee_id' => $this->fromEmployeeId,
                'status' => 'pending',
            ]);
            $clearance->devices()->attach($deviceIds);

            $receive = Receive::create([
                'employee_id' => $this->toEmployeeId,
                'status' => 'pending',
            ]);
            foreach ($deviceIds as $deviceId) {
                DeviceAndSimReceive::create([
                    'receive_id' => $receive->id,
                    'device_id' => $deviceId,
                    'notes' => $this->deviceNotes[$deviceId] ?? null,
                ]);
            }

            // Reserve the devices immediately so nothing else can claim them mid-transfer.
            // They stay reserved through both signatures - freed to the new owner only
            // when the receive side completes (DeviceTransferController::completeReceive),
            // never passing through a plain "available" state in between.
            Device::whereIn('id', $deviceIds)->update(['status' => 'pending-cancel']);

            return [$clearance->id, $receive->id];
        });

        if (!$result) {
            $this->addError('selectedDevices', 'None of the selected devices are currently held by this employee anymore.');
            return;
        }

        [$clearanceId, $receiveId] = $result;

        return $this->redirect(route('device-transfer.finish', ['clearance' => $clearanceId, 'receive' => $receiveId]));
    }

    public function render()
    {
        return view('livewire.device-transfer-picker');
    }
}
