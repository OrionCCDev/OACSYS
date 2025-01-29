<?php
namespace App\Livewire;
use App\Models\Device;
use App\Models\Receive;
use App\Models\SimCard;
use Livewire\Component;
use App\Models\Employee;
use App\Models\Clearance;
use App\Models\Consultant;
use Livewire\WithFileUploads;
use App\Models\ClientEmployee;
use Livewire\Attributes\Url; // For reactive URL updates

class ClearanceDeviceSelector extends Component
{
    use WithFileUploads;

    #[Url] // Make this property reactive in the URL
    public $selectedType = '';

    #[Url]
    public $selectedEmployee = '';

    #[Url]
    public $search = '';

    public $employees = [];
    public $devices = [];
    public $simCards = [];
    public $selectedItems = [];
    public $clearanceCode;
    public $showPrintArea = false;
    public $signedClearanceFile;
    public $showUploadModal = false;
    public $clearanceId;

    public $pendingReceives = [];
    public $pendingCancelReceives = [];
    // Reactive property for employees based on search
    public function getEmployeesProperty()
    {
        return match ($this->selectedType) {
            'employee' => Employee::query()
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('employee_id', 'like', "%{$this->search}%")
                ->get(),
            'client' => ClientEmployee::query()
                ->where('name', 'like', "%{$this->search}%")
                ->get(),
            'consultant' => Consultant::query()
                ->where('name', 'like', "%{$this->search}%")
                ->get(),
            default => collect(),
        };
    }

    // When the search term changes, update the employees list
    public function updatedSearch()
    {
        $this->employees = $this->getEmployeesProperty();
    }

    // When the selected type changes, reset the selected employee and search
    public function updatedSelectedType()
    {
        $this->selectedEmployee = '';
        $this->search = '';
        $this->employees = $this->getEmployeesProperty();
    }

    // When the selected employee changes, load their devices and SIM cards
    public function updatedSelectedEmployee()
    {
        if ($this->selectedEmployee) {
            match ($this->selectedType) {
                'employee' => $this->loadEmployeeData(),
                'client' => $this->loadClientData(),
                'consultant' => $this->loadConsultantData(),
            };
            $this->loadPendingReceives();
        }
    }

    public function showReceiveData($receiveId)
    {
        // Implement the logic to show the receiving data
        // For example, you can redirect to a route or set a property to display the data
        return redirect()->route('receive.show', ['receive' => $receiveId]);
    }

    public function showClearData($receiveId)
    {
        // Implement the logic to show the receiving data
        // For example, you can redirect to a route or set a property to display the data
        return redirect()->route('clearance.show', ['clearance' => $receiveId]);
    }

    protected function loadPendingReceives()
    {
        $this->pendingReceives = match ($this->selectedType) {
            'employee' => Receive::where('employee_id', $this->selectedEmployee)->where('status', 'pending')->get(),
            'client' => Receive::where('client_employee_id', $this->selectedEmployee)->where('status', 'pending')->get(),
            'consultant' => Receive::where('consultant_id', $this->selectedEmployee)->where('status', 'pending')->get(),
            default => collect(),
        };

        $this->pendingCancelReceives = match ($this->selectedType) {
            'employee' => Clearance::where('employee_id', $this->selectedEmployee)->where('status', 'pending')->get(),
            'client' => Clearance::where('client_employee_id', $this->selectedEmployee)->where('status', 'pending')->get(),
            'consultant' => Clearance::where('consultant_id', $this->selectedEmployee)->where('status', 'pending')->get(),
            default => collect(),
        };
    }

    // Load data for an employee
    protected function loadEmployeeData()
    {
        $employee = Employee::find($this->selectedEmployee);
        $this->devices = $employee->devices;
        $this->simCards = SimCard::where('employee_id', $this->selectedEmployee)->get();
    }

    // Load data for a client
    protected function loadClientData()
    {
        $client = ClientEmployee::find($this->selectedEmployee);
        $this->devices = $client->devices;
        $this->simCards = SimCard::where('client_employee_id', $this->selectedEmployee)->get();
    }

    // Load data for a consultant
    protected function loadConsultantData()
    {
        $consultant = Consultant::find($this->selectedEmployee);
        $this->devices = $consultant->devices;
        $this->simCards = SimCard::where('consultant_id', $this->selectedEmployee)->get();
    }

    // Redirect to the devices view
    public function redirectToDevicesView()
    {
        if ($this->selectedEmployee && $this->selectedType) {
            return redirect()->route('clearance.devices', [
                'type' => $this->selectedType,
                'id' => $this->selectedEmployee
            ]);
        }
    }

    public function render()
    {
        return view('livewire.clearance-device-selector', [
            'employees' => $this->getEmployeesProperty(),
        ]);
    }
}
