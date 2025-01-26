<?php
namespace App\Imports;

use App\Models\SimCard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SimCardImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        SimCard::where('sim_number', $row['sim_number'])
              ->update(['employee_id' => $row['employee_id']]);
    }
}
