<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\SimCard;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SimCardsImport;
use App\Exports\SimCardsExport;
class SimCardManage extends Component
{
    use WithPagination , WithFileUploads;
    
    protected $paginationTheme = 'bootstrap';
    public $SimCard_number;
    public $sim_provider;
    public $sim_plan;
    public $search = '';
    public $filterStatus = '';
    public $filterProvider = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $edtId;
    public $edtNumber;
    public $edtProvider;
    public $edtPlan;
    public $edtStatus;

    // Fields the monthly site-internet SIM report is built from.
    public $account_name;
    public $contract_no;
    public $remark;
    public $router_id;
    public $line_active = true;
    public $edtAccountName;
    public $edtContractNo;
    public $edtRemark;
    public $edtRouterId;
    public $edtLineActive = true;

    public $excelFile;

    protected $rules = [
        'SimCard_number' => 'required|unique:sim_cards,sim_number|max:17|min:9|string',
        'sim_provider' => 'required',
        'sim_plan' => 'required'
    ];
    public function importExcel()
    {
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new SimCardsImport, $this->excelFile);

        $this->reset('excelFile');
        $this->dispatch('showToast');
    }

    public function addNewSimCard()
    {
        $this->validate();

        SimCard::create([
            'sim_number' => $this->SimCard_number,
            'sim_provider' => $this->sim_provider,
            'sim_plan' => $this->sim_plan,
            'account_name' => $this->account_name ?: null,
            'contract_no' => $this->contract_no ?: null,
            'remark' => $this->remark ?: null,
            'router_id' => $this->router_id ?: null,
            'line_active' => (bool) $this->line_active,
        ]);

        $this->reset(['SimCard_number', 'sim_provider', 'sim_plan', 'account_name',
            'contract_no', 'remark', 'router_id']);
        $this->line_active = true;
        $this->dispatch('showToast');
    }

    /**
     * Reset back to page 1 whenever search/filters change - otherwise a
     * narrower result set can leave the view stuck on a now out-of-range
     * page and look like the search returned nothing.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterProvider()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function render()
    {
        $query = SimCard::query();

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('sim_number', 'like', '%'.$this->search.'%')
                    ->orWhere('sim_provider', 'like', '%'.$this->search.'%')
                    ->orWhere('sim_plan', 'like', '%'.$this->search.'%')
                    ->orWhereHas('employee', fn ($eq) => $eq->where('name', 'like', '%'.$this->search.'%'))
                    ->orWhereHas('consultant', fn ($eq) => $eq->where('name', 'like', '%'.$this->search.'%'))
                    ->orWhereHas('clientEmployee', fn ($eq) => $eq->where('name', 'like', '%'.$this->search.'%'))
                    ->orWhereHas('device', fn ($eq) => $eq->where('device_name', 'like', '%'.$this->search.'%'));
            });
        }

        if ($this->filterStatus === 'available') {
            // status alone can be stale, so "Available" also has to mean no
            // employee/consultant/client/device is actually holding it.
            $query->available();
        } elseif ($this->filterStatus !== '') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterProvider !== '') {
            $query->where('sim_provider', $this->filterProvider);
        }

        $data = $query->with('router')->orderBy($this->sortField, $this->sortDirection)->paginate(10);

        return view('livewire.sim-card-manage', [
            'data' => $data,
            // For the "fitted in router" picker on the add/edit rows.
            'routers' => \App\Models\Router::orderBy('name')->get(),
        ]);
    }

    public function del($id)
    {
        SimCard::find($id)->delete();
        $this->resetPage();
    }

    public function edt( SimCard $sim)
    {
        $this->edtId = $sim->id;
        $this->edtNumber = $sim->sim_number;
        $this->edtProvider = $sim->sim_provider;
        $this->edtPlan = $sim->sim_plan;

        $this->edtStatus = $sim->status;
        $this->edtAccountName = $sim->account_name;
        $this->edtContractNo = $sim->contract_no;
        $this->edtRemark = $sim->remark;
        $this->edtRouterId = $sim->router_id;
        $this->edtLineActive = (bool) $sim->line_active;
    }
    public function cancel()
    {
        $this->edtId = null;
        $this->reset(['edtId', 'edtNumber', 'edtProvider', 'edtPlan', 'edtStatus', 'edtAccountName', 'edtContractNo', 'edtRemark', 'edtRouterId', 'edtLineActive']);
    }

    public function exportSimCards()
    {
        return Excel::download(new SimCardsExport, 'simcards_' . now()->format('Y-m-d_H-i-s') . '.csv');
    }

    public function update( SimCard $sim)
    {
        $attributes = [
            'sim_number' => $this->edtNumber,
            'sim_provider' => $this->edtProvider,
            'sim_plan' => $this->edtPlan,
            'status' => $this->edtStatus,
            'account_name' => $this->edtAccountName ?: null,
            'contract_no' => $this->edtContractNo ?: null,
            'remark' => $this->edtRemark ?: null,
            'router_id' => $this->edtRouterId ?: null,
            'line_active' => (bool) $this->edtLineActive,
        ];

        // Marking a SIM "available" from here has to actually free it -
        // otherwise it keeps showing as taken by its old owner everywhere
        // else while this page claims it's free.
        if ($this->edtStatus === 'available') {
            $attributes['employee_id'] = null;
            $attributes['consultant_id'] = null;
            $attributes['client_employee_id'] = null;
            $attributes['device_id'] = null;
            $attributes['router_id'] = null;
        }

        $sim->update($attributes);
        $this->edtId = null;
        $this->reset(['edtId', 'edtNumber', 'edtProvider', 'edtPlan', 'edtStatus', 'edtAccountName', 'edtContractNo', 'edtRemark', 'edtRouterId', 'edtLineActive']);
        $this->dispatch('showToastOfUpdate');
    }
}
