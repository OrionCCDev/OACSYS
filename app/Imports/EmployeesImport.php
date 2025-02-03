<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeesImport implements ToModel
{
    public function model(array $row)
    {
        return new Employee([
            'employee_id' => $row[0],
            'name' => $row[1],
            'department_id' => $row[2],
            'position_id' => $row[4],
            'hire_date' => $row[6],
            // Map other columns as needed
        ]);
    }
    
}
