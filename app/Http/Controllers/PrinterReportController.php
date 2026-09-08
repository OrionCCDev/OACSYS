<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use App\Models\Project;
use App\Support\BillingCoverage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Read-only reporting over rental printers. Deliberately separate from
 * PrinterController, which is where printers are created, edited and moved
 * about: nothing here changes data, so these pages can be handed to anyone
 * who needs the numbers.
 *
 * Two views of the same records:
 *  - by project  - what is on this site, under which POs, and is it all billed
 *  - by printer  - one physical machine's whole life across every project it
 *                  has served, since a transfer creates a new row each time
 */
class PrinterReportController extends Controller
{
    /**
     * Every project that has ever had a printer, with its totals. Projects
     * with no printers at all are left out - they would just be empty rows.
     */
    public function projects(Request $request)
    {
        $query = Project::query()
            ->whereHas('printers')
            ->withCount([
                'printers',
                'printers as active_printers_count' => fn ($q) => $q->where('status', 'active'),
                'printers as transferred_printers_count' => fn ($q) => $q->where('status', 'transferred'),
                'printers as cancelled_printers_count' => fn ($q) => $q->where('status', 'cancelled'),
            ]);

        if ($request->filled('search')) {
            $query->where('project_name', 'like', '%' . $request->input('search') . '%');
        }

        if (($status = $request->input('status', 'all')) !== 'all') {
            $query->where('status', $status);
        }

        $projects = $query->orderBy('project_name')->get();

        // Coverage needs the invoice rows themselves, so it is worked out here
        // rather than in SQL - one extra query for the whole page.
        $printers = Printer::with('invoices')
            ->whereIn('project_id', $projects->pluck('id'))
            ->get()
            ->groupBy('project_id');

        $projects->each(function ($project) use ($printers) {
            $own = $printers->get($project->id, collect());
            $project->invoice_count = $own->sum(fn ($p) => $p->invoices->count());
            $project->coverage = $own->isEmpty() ? null : BillingCoverage::across($own);
        });

        return view('printers.reports.projects', compact('projects'));
    }

    /**
     * One project in full: every printer it has held, each with its PO, where
     * it sits, and every invoice raised against it while on this project.
     */
    public function project(Project $project)
    {
        $printers = Printer::with(['supplier', 'clientEmployee', 'consultant', 'invoices', 'transferredFrom.project', 'transferredTo.project'])
            ->where('project_id', $project->id)
            ->orderByDesc('start_date')
            ->get();

        $coverage = $printers->mapWithKeys(fn ($p) => [$p->id => BillingCoverage::for($p)]);
        $overall = $printers->isEmpty() ? null : BillingCoverage::across($printers);

        $invoiceCount = $printers->sum(fn ($p) => $p->invoices->count());
        $suppliers = $printers->pluck('supplier.name')->filter()->unique()->sort()->values();

        return view('printers.reports.project', compact(
            'project', 'printers', 'coverage', 'overall', 'invoiceCount', 'suppliers'
        ));
    }

    /**
     * The monthly printers sheet: one block per project, its suppliers and
     * counts, then a Big/Small split with where each group sits.
     *
     * "During the month" means the rental overlapped it at any point - started
     * on or before the month ended, and had not already ended before it began.
     * A printer transferred mid-month therefore appears under both projects,
     * which is correct: both held it that month.
     */
    public function monthly(Request $request)
    {
        $month = $this->resolveMonth($request->input('month'));
        [$from, $to] = [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()];

        $printers = Printer::with(['project', 'supplier'])
            ->whereDate('start_date', '<=', $to)
            ->where(fn ($q) => $q->whereNull('end_date')->orWhereDate('end_date', '>=', $from))
            ->get();

        $rows = $this->buildMonthlyRows($printers);

        return view('printers.reports.monthly', [
            'month' => $month,
            'rows' => $rows,
            'printers' => $printers,
            'signatory' => $this->itManagerName(),
        ]);
    }

    /** The same sheet as a PDF, for signing and filing. */
    public function monthlyPdf(Request $request)
    {
        $month = $this->resolveMonth($request->input('month'));
        [$from, $to] = [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()];

        $printers = Printer::with(['project', 'supplier'])
            ->whereDate('start_date', '<=', $to)
            ->where(fn ($q) => $q->whereNull('end_date')->orWhereDate('end_date', '>=', $from))
            ->get();

        $pdf = Pdf::loadView('printers.reports.monthly-pdf', [
            'month' => $month,
            'rows' => $this->buildMonthlyRows($printers),
            'printers' => $printers,
            'signatory' => $this->itManagerName(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('printers-report-' . $month->format('Y-m') . '.pdf');
    }

    /** Accepts YYYY-MM from the month picker; anything else means this month. */
    private function resolveMonth(?string $input): Carbon
    {
        try {
            return $input ? Carbon::createFromFormat('Y-m', $input)->startOfMonth() : Carbon::now()->startOfMonth();
        } catch (\Throwable) {
            return Carbon::now()->startOfMonth();
        }
    }

    /**
     * One entry per project: its suppliers with counts, and a line per size.
     * A "Not set" size line appears only when some printers have no size, so
     * the size lines always add up to the project's total rather than quietly
     * losing rows.
     */
    private function buildMonthlyRows($printers): array
    {
        $rows = [];

        foreach ($printers->groupBy('project_id') as $projectPrinters) {
            $project = $projectPrinters->first()->project;

            $suppliers = $projectPrinters
                ->groupBy(fn ($p) => $p->supplier->name ?? 'No supplier')
                ->map->count()
                ->sortKeys();

            $sizes = [];
            foreach (['big', 'small'] as $size) {
                $of = $projectPrinters->where('size', $size);
                $sizes[] = [
                    'label' => $size === 'big' ? 'Big' : 'Small',
                    'count' => $of->count(),
                    'designation' => $of->map->designationLabel()->unique()->filter(fn ($d) => $d !== '-')->implode(' & ') ?: '-',
                ];
            }

            $unset = $projectPrinters->whereNull('size');
            if ($unset->isNotEmpty()) {
                $sizes[] = [
                    'label' => 'Not set',
                    'count' => $unset->count(),
                    'designation' => $unset->map->designationLabel()->unique()->filter(fn ($d) => $d !== '-')->implode(' & ') ?: '-',
                ];
            }

            $rows[] = [
                'project' => $project,
                'suppliers' => $suppliers,
                'total' => $projectPrinters->count(),
                'sizes' => $sizes,
            ];
        }

        usort($rows, fn ($a, $b) => strcmp($a['project']->project_code ?? '', $b['project']->project_code ?? ''));

        return $rows;
    }

    /**
     * Who signs the sheet off. Uses the IT manager on record when there is
     * one; the PDF still prints a signature line either way.
     */
    private function itManagerName(): ?string
    {
        // Users hold the roles and point at their employee record, not the
        // other way round, so the lookup starts from the user side.
        $user = \App\Models\User::whereHas('roles', fn ($q) => $q->whereIn('name', ['o-super-admin', 'o-admin']))
            ->with('employee')
            ->orderBy('id')
            ->first();

        return $user?->employee?->name ?? $user?->name;
    }

    /**
     * One physical printer across its whole life. Because a transfer creates a
     * new record, the report walks the chain and reports on all of them
     * together - total time on rent, every project served, every invoice.
     */
    public function printer(Printer $printer)
    {
        $printer->load(['project', 'supplier', 'invoices']);

        $chain = $printer->lifecycleChain()
            ->each(fn ($link) => $link->load(['project', 'supplier', 'clientEmployee', 'consultant', 'invoices']));

        $coverage = $chain->mapWithKeys(fn ($p) => [$p->id => BillingCoverage::for($p)]);
        $overall = BillingCoverage::across($chain);

        $invoices = $chain->flatMap(fn ($p) => $p->invoices)->sortBy('start_date')->values();

        return view('printers.reports.printer', compact(
            'printer', 'chain', 'coverage', 'overall', 'invoices'
        ));
    }
}
