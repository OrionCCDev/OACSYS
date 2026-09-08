<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use App\Models\Project;
use App\Support\BillingCoverage;
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
