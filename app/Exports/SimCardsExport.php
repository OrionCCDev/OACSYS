<?php
namespace App\Exports;

use App\Models\SimCard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SimCardsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return SimCard::with(['employee', 'clientEmployee', 'consultant'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'SimCard Number',
            'Provider',
            'Plan',
            'Owner Type',
            'Owner Name',
            'Owner ID',
            'Owner Department',
            'Owner Position',
            'Owner Project',
        ];
    }

    public function map($simCard): array
    {
        // Determine owner name and type
        $ownerName = '';
        $ownerType = 'Unassigned';

        if ($simCard->employee) {
            $ownerName = $simCard->employee->name;
            $ownerType = 'Employee';
        } elseif ($simCard->clientEmployee) {
            $ownerName = $simCard->clientEmployee->name;
            $ownerType = 'Client Employee';
        } elseif ($simCard->consultant) {
            $ownerName = $simCard->consultant->name;
            $ownerType = 'Consultant';
        }

        return [
            $simCard->id,
            $simCard->sim_number,
            $simCard->sim_provider,
            $simCard->sim_plan,
            $ownerType,
            $ownerName,
            $simCard->employee->employee_id ?? 'Didn\'t assign',
            $simCard->employee->department->name ?? 'Didn\'t assign',
            $simCard->employee->position->name ?? 'Didn\'t assign',
            $simCard->employee->project->project_code ?? $simCard->clientEmployee->project->project_code ?? $simCard->consultant->project->project_code ?? 'Didn\'t assign',
        ];
    }
}
