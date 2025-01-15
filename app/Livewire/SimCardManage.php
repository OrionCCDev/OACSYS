<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\SimCard;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class SimCardManage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    #[Rule('required|unique:sim_cards,sim_number|max:17|min:9|string')]
    public $SimCard_number;
    public $search;
    public $edtNumber;
    public $edtId;

    public function addNewSimCard()
    {
        $this->validateOnly('SimCard_number');
        SimCard::create([
            'sim_number' => $this->SimCard_number,
            'status' => 'available',
        ]);

        $this->reset('SimCard_number');
        $this->resetPage();
        $this->dispatch('showToast');
    }

    public function render()
    {
        $data = SimCard::latest()->where('sim_number' , 'like' , "%$this->search%")->paginate(10);
        return view('livewire.sim-card-manage' ,compact('data'));
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
    }
    public function cancel()
    {
        $this->reset(['edtId' , 'edtNumber']);
    }
    public function update( SimCard $sim)
    {
        $this->validateOnly('edtNumber', [
            'edtNumber' => 'required|max:17|min:9|string|unique:sim_cards,sim_number,'.$sim->id
        ]);
        $sim->update([
            'sim_number' => $this->edtNumber
        ]);

        $this->reset(['edtId' , 'edtNumber']);

        $this->dispatch('showToastOfUpdate');
    }
}
