<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * The SIM report as a spreadsheet, in the same column order the importer
 * reads back.
 *
 * It takes plain rows rather than models, so the same class serves both the
 * live month (download, edit, upload again) and an issued report (a copy of
 * what went out).
 */
class InternetSimReportExport implements FromArray, WithHeadings, ShouldAutoSize
{
    /** @param array<int, array<string, mixed>> $rows */
    public function __construct(private array $rows)
    {
    }

    /** Exactly what the importer looks for, so the file can go straight back in. */
    public function headings(): array
    {
        return [
            'SL NO',
            'SIM NUMBER',
            'PROVIDOR',
            'ACOUNT NAME',
            'ACCOUNT SITE',
            'SIM status',
            'SIM S/N',
            'CONTRACT NO',
            'Router S/N',
            'Remark',
        ];
    }

    public function array(): array
    {
        return array_map(fn ($row) => [
            $row['sl_no'],
            $row['sim_number'],
            $row['sim_provider'],
            $row['account_name'],
            $row['account_site'],
            $row['line_active'] ? 'active' : 'NOT active',
            $row['sim_serial'],
            $row['contract_no'],
            $row['router_serial'],
            $row['remark'],
        ], $this->rows);
    }
}
