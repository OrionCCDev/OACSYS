<?php
namespace App\Imports;

use App\Models\SimCard;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SimCardsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row['sim_number']) || empty($row['sim_plan'])) {
            return null;
        }

        // Check if employee exists before setting the ID
        $employeeId = null;
        if (!empty($row['employee_id'])) {
            $employee = Employee::find($row['employee_id']);
            $employeeId = $employee ? $employee->id : null;
        }

        return SimCard::create([
            'sim_number' => $row['sim_number'],
            'sim_plan' => $row['sim_plan'],
            'employee_id' => $employeeId,
        ]);
    }
}
