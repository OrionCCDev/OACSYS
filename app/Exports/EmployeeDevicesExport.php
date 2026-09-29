<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

/**
 * Devices with employees, one row per device.
 *
 * Every cell is written as text. Serial numbers and Orion IDs are digits
 * that are not numbers: left to Excel, a long serial is rounded and a
 * leading zero is dropped.
 */
class EmployeeDevicesExport extends StringValueBinder implements FromArray, WithHeadings, ShouldAutoSize, WithCustomValueBinder
{
    /** @param array<int, array<string, mixed>> $rows */
    public function __construct(private array $rows)
    {
    }

    public function headings(): array
    {
        return [
            'SL NO', 'ORION ID', 'EMPLOYEE', 'DEPARTMENT', 'POSITION', 'PROJECT',
            'DEVICE CODE', 'DEVICE', 'TYPE', 'MODEL', 'SERIAL NO', 'STATUS',
        ];
    }

    public function array(): array
    {
        return array_map(fn ($row) => [
            $row['sl_no'], $row['orion_id'], $row['employee'], $row['department'], $row['position'], $row['project'],
            $row['device_code'], $row['device_name'], $row['device_type'], $row['device_model'], $row['serial_number'],
            $row['status'],
        ], $this->rows);
    }
}
