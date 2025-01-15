<?php

namespace App\Livewire;

use App\Models\SimCard;
use Livewire\Component;

class ClientEmployeeFormForSimCards extends Component
{
    public function render()
    {
        $availableSims = SimCard::whereNull('client_employee_id')
        ->whereNull('employee_id')
        ->whereNull('consultant_id')
        ->get();

        return view('livewire.client-employee-form-for-sim-cards', [
            'availableSims' => $availableSims
        ]);

    }
}
