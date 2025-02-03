<?php

namespace App\Imports;


use Carbon\Carbon;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
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
            ['employee_id' => $row[0]],
            [
                'name' => $row[1],
                'department_id' => $row[2],
                'position_id' => $row[3],
                'hire_date' => $this->parseDate($row[4]),
                'type' => $row[5],
                // Map other columns as needed
            ]
        );
    }

    private function parseDate($value)
    {
        try {
            // Handle Excel timestamp numbers and string dates
            return is_numeric($value)
                ? Carbon::instance(Date::excelToDateTimeObject($value))
                : Carbon::createFromFormat('Y-m-d', $value);
        } catch (\Exception $e) {
            return null; // Handle invalid dates appropriately
        }
    }
}
