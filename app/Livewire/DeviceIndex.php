<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Device;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class DeviceIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterType = '';
    public $filterStoredAt = '';
    public $filterHealth = '';
    public $filterStatus = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterStoredAt()
    {
        $this->resetPage();
    }

    public function updatingFilterHealth()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterType = '';
        $this->filterStoredAt = '';
        $this->filterHealth = '';
        $this->filterStatus = '';
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

    public function exportPdf()
    {
        $devices = $this->getFilteredDevices();

        $pdf = Pdf::loadView('pdf.devices', [
            'devices' => $devices,
            'generatedDate' => now()->format('Y-m-d H:i:s')
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'devices-report-' . now()->format('Y-m-d') . '.pdf');
    }

    private function getFilteredDevices()
    {
        $query = Device::query();

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('device_name', 'like', '%'.$this->search.'%')
                  ->orWhere('device_code', 'like', '%'.$this->search.'%');
            });
        }

        // Apply type filter
        if ($this->filterType) {
            $query->where('device_type', $this->filterType);
        }

        // Apply stored_at filter
        if ($this->filterStoredAt) {
            $query->where('stored_at', $this->filterStoredAt);
        }

        // Apply health filter
        if ($this->filterHealth) {
            $query->where('health', $this->filterHealth);
        }

        // Apply status filter
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        return $query->orderByRaw("CASE WHEN status = 'available' THEN 0 ELSE 1 END")
                     ->orderBy('updated_at', 'desc')
                     ->get();
    }

    public function render()
    {
        $query = Device::query();

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('device_name', 'like', '%'.$this->search.'%')
                  ->orWhere('device_code', 'like', '%'.$this->search.'%');
            });
        }

        // Apply type filter
        if ($this->filterType) {
            $query->where('device_type', $this->filterType);
        }

        // Apply stored_at filter
        if ($this->filterStoredAt) {
            $query->where('stored_at', $this->filterStoredAt);
        }

        // Apply health filter
        if ($this->filterHealth) {
            $query->where('health', $this->filterHealth);
        }

        // Apply status filter
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $devices = $query->orderByRaw("CASE WHEN status = 'available' THEN 0 ELSE 1 END")
                        ->orderBy('updated_at', 'desc')
                        ->paginate(10);

        // Get unique values for filters
        $deviceTypes = Device::distinct()->pluck('device_type')->filter();
        $storedAtOptions = ['office', 'server', 'store', 'delivered'];
        $healthOptions = ['New', 'Mediam_use', 'Bad_use', 'Scrap', 'Need_fix'];
        $statusOptions = ['available', 'taken', 'pending-receiving', 'pending-cancel', 'In-Project-Site', 'pending-project-device'];

        return view('livewire.device-index', [
            'devices' => $devices,
            'deviceTypes' => $deviceTypes,
            'storedAtOptions' => $storedAtOptions,
            'healthOptions' => $healthOptions,
            'statusOptions' => $statusOptions,
        ]);
    }
}
