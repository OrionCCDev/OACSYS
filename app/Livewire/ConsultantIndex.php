<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Consultant;

class ConsultantIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $consultants = Consultant::where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('company_name', 'like', '%'.$this->search.'%')
                        ->paginate(10);

        return view('livewire.consultant-index', [
            'consultants' => $consultants,
        ]);
    }
}
