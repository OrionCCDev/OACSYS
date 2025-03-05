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
    public $edtId;
    public $edtNumber;
    public $edtProvider;
    public $edtPlan;
    public $edtStatus;

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
            'sim_plan' => $this->sim_plan
        ]);

        $this->reset(['SimCard_number', 'sim_provider', 'sim_plan']);
        $this->dispatch('showToast');
    }

    public function render()
    {
        $data = SimCard::where('sim_number', 'like', '%'.$this->search.'%')
            ->orWhere('sim_provider', 'like', '%'.$this->search.'%')
            ->orWhere('sim_plan', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.sim-card-manage', [
            'data' => $data
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
    }
    public function cancel()
    {
        $this->edtId = null;
        $this->reset(['edtId', 'edtNumber', 'edtProvider', 'edtPlan' , 'edtStatus']);
    }

    public function exportSimCards()
    {
        return Excel::download(new SimCardsExport, 'simcards_' . now()->format('Y-m-d_H-i-s') . '.csv');
    }

    public function update( SimCard $sim)
    {


        $sim->update([
            'sim_number' => $this->edtNumber,
            'sim_provider' => $this->edtProvider,
            'sim_plan' => $this->edtPlan,
            'status' => $this->edtStatus
        ]);
        $this->edtId = null;
        $this->reset(['edtId', 'edtNumber', 'edtProvider', 'edtPlan' ,'edtStatus']);
        $this->dispatch('showToastOfUpdate');
    }
}
