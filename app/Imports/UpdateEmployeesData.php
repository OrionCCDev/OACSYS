<?php

namespace App\Imports;


use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UpdateEmployeesData implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return Employee::updateOrCreate(
            ['employee_id' => $row['employee_id']],
            [
                'name' => $row['name'],
                'department_id' => $row['department_id'],
                'position_id' => $row['position_id'],
                'hire_date' => $row['hire_date'],
                'type' => $row['type'],
                // Map other columns as needed
            ]
        );
    }
}
