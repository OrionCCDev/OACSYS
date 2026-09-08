<?php

namespace App\Http\Controllers;

use App\Exports\InternetSimReportExport;
use App\Models\InternetSim;
use App\Models\SimMonthlyReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * The monthly site-internet SIM report.
 *
 * Two things live here, and the difference matters:
 *
 *  - making a report: pick a month, check what is on it, drop anything that
 *    should not be, and issue it.
 *  - issued reports: a frozen copy of what was confirmed. Editing or deleting
 *    a line afterwards never changes one, so a signed sheet can always be
 *    produced again exactly as it went out.
 *
 * Making one is a walk, not a single screen: month first, then a warning if
 * that month has already been reported, and only then the lines to tick. That
 * order stops a second report being raised against the wrong month unnoticed.
 */
class SimReportController extends Controller
{
    /**
     * Step 1 - which month? No month in the URL means nothing has been chosen
     * yet, so only the picker is shown.
     */
    public function monthly(Request $request)
    {
        if (!$request->filled('month')) {
            return view('sim-report.choose-month', [
                'suggested' => Carbon::now()->subMonthNoOverflow(),
                'recent' => SimMonthlyReport::orderByDesc('report_month')->orderByDesc('sequence')->limit(5)->get(),
            ]);
        }

        $month = $this->resolveMonth($request->input('month'));
        $existing = $this->reportsFor($month);

        // Step 2 - that month has been reported before. Say so, show it, and
        // let the choice be made deliberately rather than by carrying on.
        if ($existing->isNotEmpty() && !$request->boolean('new')) {
            return view('sim-report.exists', [
                'month' => $month,
                'existingReports' => $existing,
            ]);
        }

        // Step 3 - the lines, to tick over and issue.
        return view('sim-report.monthly', [
            'month' => $month,
            'sims' => $this->simsFor($month),
            'existingReports' => $existing,
        ]);
    }

    /**
     * Issue the month: copy the ticked lines into a report that will not
     * change again.
     *
     * A line left unticked is simply not on this month's sheet - the live
     * record is untouched.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|date_format:Y-m',
            'sim_ids' => 'required|array|min:1',
            'sim_ids.*' => 'integer',
            'notes' => 'nullable|string|max:1000',
        ]);

        $month = Carbon::createFromFormat('Y-m', $validated['month'])->startOfMonth();

        $sims = $this->simsFor($month)->whereIn('id', $validated['sim_ids'])->values();

        if ($sims->isEmpty()) {
            return redirect()->route('sim-report.monthly', ['month' => $month->format('Y-m'), 'new' => 1])
                ->with('error', 'None of the selected lines could be found for that month.');
        }

        $report = DB::transaction(function () use ($month, $sims, $validated) {
            // A month can hold several reports; the new one goes after the last,
            // and the earlier ones stay exactly as they were.
            $sequence = (SimMonthlyReport::where('report_month', $month)->max('sequence') ?? 0) + 1;

            $report = SimMonthlyReport::create([
                'report_month' => $month,
                'sequence' => $sequence,
                'line_count' => $sims->count(),
                'active_count' => $sims->where('line_active', true)->count(),
                'inactive_count' => $sims->where('line_active', false)->count(),
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);

            foreach ($sims as $i => $sim) {
                $report->lines()->create([
                    'internet_sim_id' => $sim->id,
                    'sl_no' => $i + 1,
                    'sim_number' => $sim->sim_number,
                    'sim_provider' => $sim->sim_provider,
                    'account_name' => $sim->account_name,
                    'account_site' => $sim->account_site,
                    'line_active' => $sim->line_active,
                    'sim_serial' => $sim->sim_serial,
                    'contract_no' => $sim->contract_no,
                    'router_serial' => $sim->router?->serial_number,
                    'remark' => $sim->remark,
                ]);
            }

            return $report;
        });

        return redirect()->route('sim-report.show', $report->id)
            ->with('success', 'Report saved for ' . $report->monthLabel() . '. Export it as PDF or Excel below.');
    }

    /** Every issued report, newest month first. */
    public function index()
    {
        $reports = SimMonthlyReport::with('creator')
            ->orderByDesc('report_month')
            ->orderByDesc('sequence')
            ->paginate(20);

        return view('sim-report.saved-index', compact('reports'));
    }

    /** One issued report, exactly as it was confirmed. */
    public function show(SimMonthlyReport $report)
    {
        $report->load('lines', 'creator');

        return view('sim-report.saved-show', compact('report'));
    }

    /** The issued report as a PDF, for signing and filing. */
    public function pdf(SimMonthlyReport $report)
    {
        $report->load('lines');

        $pdf = Pdf::loadView('sim-report.monthly-pdf', [
            'month' => $report->report_month,
            'issuedAt' => $report->created_at,
            'version' => $report->versionLabel(),
            'rows' => $this->rowsFromReport($report),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('sim-report-' . $this->reportSlug($report) . '.pdf');
    }

    /** The issued report as Excel. */
    public function excel(SimMonthlyReport $report)
    {
        $report->load('lines');

        return Excel::download(
            new InternetSimReportExport($this->rowsFromReport($report)),
            'sim-report-' . $this->reportSlug($report) . '.xlsx'
        );
    }

    /**
     * Remove an issued report. Only for one raised by mistake - the point of
     * these is that they stay put, so the view asks before doing it.
     */
    public function destroy(SimMonthlyReport $report)
    {
        $label = $report->monthLabel();
        $report->delete();

        return redirect()->route('sim-report.index')
            ->with('success', 'Deleted the ' . $label . ' report.');
    }

    /**
     * The live month as Excel, in the column order the importer reads.
     *
     * This is the month-to-month shortcut: download it, change what moved,
     * upload it again on the Internet SIMs page.
     */
    public function monthlyExcel(Request $request)
    {
        $month = $this->resolveMonth($request->input('month'), Carbon::now()->subMonthNoOverflow());

        $rows = $this->simsFor($month)->values()->map(fn ($sim, $i) => [
            'sl_no' => $i + 1,
            'sim_number' => $sim->sim_number,
            'sim_provider' => $sim->sim_provider,
            'account_name' => $sim->account_name,
            'account_site' => $sim->account_site,
            'line_active' => (bool) $sim->line_active,
            'sim_serial' => $sim->sim_serial,
            'contract_no' => $sim->contract_no,
            'router_serial' => $sim->router?->serial_number,
            'remark' => $sim->remark,
        ])->all();

        return Excel::download(
            new InternetSimReportExport($rows),
            'sim-report-' . $month->format('Y-m') . '.xlsx'
        );
    }

    /** Plain rows, so PDF and Excel do not care where they came from. */
    private function rowsFromReport(SimMonthlyReport $report): array
    {
        return $report->lines->map(fn ($l) => [
            'sl_no' => $l->sl_no,
            'sim_number' => $l->sim_number,
            'sim_provider' => $l->sim_provider,
            'account_name' => $l->account_name,
            'account_site' => $l->account_site,
            'line_active' => (bool) $l->line_active,
            'sim_serial' => $l->sim_serial,
            'contract_no' => $l->contract_no,
            'router_serial' => $l->router_serial,
            'remark' => $l->remark,
        ])->all();
    }

    private function reportSlug(SimMonthlyReport $report): string
    {
        return $report->report_month->format('Y-m')
            . ($report->sequence > 1 ? '-v' . $report->sequence : '');
    }

    /**
     * Lines as they stand for a month: anything recorded by the end of it.
     * A line added later does not appear on an earlier month.
     */
    private function simsFor(Carbon $month)
    {
        return InternetSim::with('router')
            ->where('created_at', '<=', $month->copy()->endOfMonth())
            ->orderBy('sim_provider')
            ->orderBy('account_name')
            ->orderBy('sim_number')
            ->get();
    }

    private function reportsFor(Carbon $month)
    {
        return SimMonthlyReport::with('creator')
            ->where('report_month', $month->copy()->startOfMonth())
            ->orderByDesc('sequence')
            ->get();
    }

    /** Accepts YYYY-MM from the month picker; anything else falls back. */
    private function resolveMonth(?string $input, ?Carbon $default = null): Carbon
    {
        $default ??= Carbon::now()->subMonthNoOverflow();

        try {
            return $input
                ? Carbon::createFromFormat('Y-m', $input)->startOfMonth()
                : $default->copy()->startOfMonth();
        } catch (\Throwable) {
            return $default->copy()->startOfMonth();
        }
    }
}
