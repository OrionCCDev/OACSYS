<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeDevicesExport;
use App\Models\Department;
use App\Models\Device;
use App\Models\Employee;
use App\Support\PdfFonts;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Which devices are with which employees.
 *
 * It is about the people still working here: somebody who has resigned is
 * left out, even if a device is still recorded against them. Those are not
 * hidden, though - a device on a resigned employee is one that was never
 * collected or never cleared, so the page counts them and can list them
 * instead.
 *
 * Read-only. Nothing here changes a device or an employee.
 */
class EmployeeDeviceReportController extends Controller
{
    /** What a device's status means while somebody has it. */
    public const STATUSES = [
        'taken' => 'Received',
        'pending-receiving' => 'Waiting for signature',
        'pending-cancel' => 'Being returned',
    ];

    public function index(Request $request)
    {
        $filters = $this->filters($request);

        return view('reports.employee-devices', [
            'filters' => $filters,
            'employees' => $this->employees($filters)->paginate(25)->withQueryString(),
            'totals' => $this->totals($filters),
            'resignedHolding' => $this->totals(['who' => 'resigned'] + $this->filters(new Request())),
            'departments' => Department::orderBy('name')->get(['id', 'name']),
            'types' => Device::whereNotNull('employee_id')->whereNotNull('device_type')
                ->where('device_type', '!=', '')->distinct()->orderBy('device_type')->pluck('device_type'),
            'statuses' => self::STATUSES,
        ]);
    }

    public function excel(Request $request)
    {
        $filters = $this->filters($request);

        return Excel::download(new EmployeeDevicesExport($this->rows($filters)), $this->fileName($filters) . '.xlsx');
    }

    public function pdf(Request $request)
    {
        $filters = $this->filters($request);

        $pdf = Pdf::loadView('reports.employee-devices-pdf', [
            'filters' => $filters,
            'rows' => $this->rows($filters),
            'totals' => $this->totals($filters),
            'describe' => $this->describe($filters),
        ])->setPaper('a4', 'landscape');
        PdfFonts::register($pdf->getDomPDF());

        return $pdf->stream($this->fileName($filters) . '.pdf');
    }

    /** Only values the page offers; anything else falls back to "everything". */
    private function filters(Request $request): array
    {
        $status = (string) $request->query('status', '');

        return [
            'who' => $request->query('who') === 'resigned' ? 'resigned' : 'current',
            'search' => trim((string) $request->query('search', '')),
            'department' => ctype_digit((string) $request->query('department')) ? (int) $request->query('department') : null,
            'type' => trim((string) $request->query('type', '')),
            'status' => isset(self::STATUSES[$status]) ? $status : '',
        ];
    }

    /** The devices that count, within one employee's devices. */
    private function deviceScope($query, array $filters)
    {
        return $query
            ->when($filters['type'] !== '', fn ($q) => $q->where('device_type', $filters['type']))
            ->when($filters['status'] !== '', fn ($q) => $q->where('status', $filters['status']));
    }

    private function employees(array $filters)
    {
        $devices = fn ($q) => $this->deviceScope($q, $filters);

        return Employee::query()
            ->when(
                $filters['who'] === 'resigned',
                fn ($q) => $q->where('type', 'resigned'),
                fn ($q) => $q->where('type', '!=', 'resigned')
            )
            ->when($filters['department'], fn ($q, $department) => $q->where('department_id', $department))
            ->whereHas('devices', $devices)
            ->when($filters['search'] !== '', function ($q) use ($filters, $devices) {
                $term = '%' . $filters['search'] . '%';
                $q->where(function ($w) use ($term, $devices) {
                    $w->where('name', 'like', $term)
                        ->orWhere('employee_id', 'like', $term)
                        ->orWhereHas('devices', fn ($d) => $devices($d)->where(function ($x) use ($term) {
                            $x->where('device_code', 'like', $term)
                                ->orWhere('device_name', 'like', $term)
                                ->orWhere('device_model', 'like', $term)
                                ->orWhere('serial_number', 'like', $term);
                        }));
                });
            })
            ->with([
                'department', 'position', 'project',
                'devices' => fn ($q) => $devices($q)->orderBy('device_type')->orderBy('device_code'),
            ])
            ->orderBy('name')
            ->orderBy('id');
    }

    private function totals(array $filters): array
    {
        $employeeIds = $this->employees($filters)->reorder()->pluck('employees.id');

        $byType = $this->deviceScope(Device::whereIn('employee_id', $employeeIds), $filters)
            ->selectRaw("COALESCE(NULLIF(device_type, ''), 'Unspecified') as kind, count(*) as total")
            ->groupBy('kind')
            ->orderByDesc('total')
            ->pluck('total', 'kind')
            ->map(fn ($n) => (int) $n);

        return [
            'employees' => $employeeIds->count(),
            'devices' => $byType->sum(),
            'by_type' => $byType->all(),
        ];
    }

    /** One row per device, for the exports. */
    private function rows(array $filters): array
    {
        $rows = [];

        foreach ($this->employees($filters)->get() as $employee) {
            foreach ($employee->devices as $device) {
                $rows[] = [
                    'sl_no' => count($rows) + 1,
                    'orion_id' => (string) ($employee->employee_id ?? ''),
                    'employee' => (string) $employee->name,
                    'department' => (string) ($employee->department?->name ?? ''),
                    'position' => (string) ($employee->position?->name ?? ''),
                    'project' => (string) ($employee->project?->project_code ?? ''),
                    'device_code' => (string) $device->device_code,
                    'device_name' => (string) ($device->device_name ?? ''),
                    'device_type' => (string) ($device->device_type ?? ''),
                    'device_model' => (string) ($device->device_model ?? ''),
                    'serial_number' => (string) ($device->serial_number ?? ''),
                    'status' => self::statusLabel($device->status),
                ];
            }
        }

        return $rows;
    }

    public static function statusLabel(?string $status): string
    {
        return self::STATUSES[$status] ?? ucfirst(str_replace('-', ' ', (string) $status));
    }

    /** The filters in words, for the top of the PDF. */
    private function describe(array $filters): string
    {
        $parts = [$filters['who'] === 'resigned' ? 'Resigned employees' : 'Current employees'];

        if ($filters['department']) {
            $parts[] = 'Department: ' . (Department::find($filters['department'])?->name ?? '-');
        }
        if ($filters['type'] !== '') {
            $parts[] = 'Type: ' . $filters['type'];
        }
        if ($filters['status'] !== '') {
            $parts[] = 'Status: ' . self::STATUSES[$filters['status']];
        }
        if ($filters['search'] !== '') {
            $parts[] = 'Search: ' . $filters['search'];
        }

        return implode('  |  ', $parts);
    }

    private function fileName(array $filters): string
    {
        return 'devices-with-' . $filters['who'] . '-employees-' . now()->format('Y-m-d');
    }
}
