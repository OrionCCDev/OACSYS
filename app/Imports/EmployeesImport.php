<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class EmployeesImport implements ToCollection
{
    public function collection(Collection $rows){

        foreach ($rows as $rowIndex => $row) {
            try {
                    $employeeId = $row[0];

                    $name = $row[1];

                    $departmentId = $row[2];

                    $positionId = $row[3];

                    $hireDate = $this->parseDate($row[4], $rowIndex);

                    $type = strtolower($row[5]);
                    // process each row

                    // Validate type

                    $allowedTypes = ['owner', 'manager', 'employee', 'labor', 'resigned'];

                    if (!in_array($type, $allowedTypes)) {

                    $type = 'employee'; // default to employee

                    }

                    Employee::updateOrCreate(

                        ['employee_id' => $employeeId],

                        [

                        'name' => $name,

                        'department_id' => $departmentId,

                        'position_id' => $positionId,

                        'hire_date' => $hireDate,

                        'type' => $type,

                        ]

                        );
                    } catch (\Exception $e) {
                        Log::error("Row {$rowIndex} error: ".$e->getMessage());
                    }
                }
    }
    private function parseDate($rawDate, $rowIndex)
    {
        if (is_numeric($rawDate)) {
            // Convert Excel serial date (Windows epoch)
            return Carbon::create(1899, 12, 30)->addDays((int)$rawDate);
        }

        $dateString = trim((string)$rawDate);

        if (empty($dateString)) {
            return null;
        }

        // Try common date formats
        $formats = [
            'Y-m-d', 'd/m/Y', 'm/d/Y', 'd-M-Y', 'Y.m.d',
            'Y/m/d', 'd F Y', 'Y-d-m', 'Y/m/d H:i:s'
        ];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $dateString);
            } catch (\Exception $e) {
                continue;
            }
        }

        // Final attempt with loose parsing
        try {
            return Carbon::parse($dateString);
        } catch (\Exception $e) {
            Log::warning("Row {$rowIndex}: Invalid date '{$dateString}'");
            return null;
        }
}
}
