<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * The monthly SIM report as a spreadsheet, in the same column order the
 * importer reads back.
 *
 * That round trip is the point: download the month, change what moved in
 * Excel, upload it again. Lines are matched on SIM number, account site and
 * SIM S/N, so edits land on the right rows and nothing is duplicated.
 */
class InternetSimReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(private Collection $sims)
    {
    }

    public function collection(): Collection
    {
        return $this->sims;
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

    public function map($sim): array
    {
        static $n = 0;

        return [
            ++$n,
            $sim->sim_number,
            $sim->sim_provider,
            $sim->account_name,
            $sim->account_site,
            $sim->line_active ? 'active' : 'NOT active',
            $sim->sim_serial,
            $sim->contract_no,
            $sim->router?->serial_number,
            $sim->remark,
        ];
    }
}
