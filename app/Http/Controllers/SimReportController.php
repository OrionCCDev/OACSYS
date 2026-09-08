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
 *  - the working view: today's lines for a chosen month, where rows can be
 *    dropped before issuing.
 *  - issued reports: a frozen copy of what was confirmed. Editing or deleting
 *    a line afterwards never changes one, so a signed sheet can always be
 *    produced again exactly as it went out.
 */
class SimReportController extends Controller
{
    /**
     * The working view for a month, ready to check over and issue.
     *
     * Defaults to last month, since a month is normally reported once it has
     * finished. If that month already has an issued report the page says so
     * and links to it rather than letting a second one be made unnoticed.
     */
    public function monthly(Request $request)
    {
        $month = $this->resolveMonth($request->input('month'), Carbon::now()->subMonthNoOverflow());

        return view('sim-report.monthly', [
            'month' => $month,
            'sims' => $this->simsFor($month),
            'existingReports' => $this->reportsFor($month),
        ]);
    }

    /**
     * Issue the month: copy the chosen lines into a report that will not
     * change again.
     *
     * Any line not ticked is simply left out - the live record is untouched,
     * it just does not appear on this month's sheet.
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

        $sims = $this->simsFor($month)
            ->whereIn('id', $validated['sim_ids'])
            ->values();

        if ($sims->isEmpty()) {
            return redirect()->route('sim-report.monthly', ['month' => $month->format('Y-m')])
                ->with('error', 'None of the selected lines could be found for that month.');
        }

        $report = DB::transaction(function () use ($month, $sims, $validated) {
            // A month can hold several reports; the new one goes after the last.
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
            ->with('success', 'Report issued for ' . $report->monthLabel() . '. It is saved as it stands now.');
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
            // Plain rows, so the template does not care whether they came from
            // a live SIM or an issued line.
            'rows' => $report->lines->map(fn ($l) => [
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
            ])->all(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download(
            'sim-report-' . $report->report_month->format('Y-m')
            . ($report->sequence > 1 ? '-v' . $report->sequence : '') . '.pdf'
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
     * The same sheet as Excel, in the column order the importer reads.
     *
     * This is the month-to-month workflow: download the last report, change
     * what moved, upload it again on the Internet SIMs page.
     */
    public function monthlyExcel(Request $request)
    {
        $month = $this->resolveMonth($request->input('month'), Carbon::now()->subMonthNoOverflow());

        return Excel::download(
            new InternetSimReportExport($this->simsFor($month)),
            'sim-report-' . $month->format('Y-m') . '.xlsx'
        );
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
        $default ??= Carbon::now();

        try {
            return $input
                ? Carbon::createFromFormat('Y-m', $input)->startOfMonth()
                : $default->copy()->startOfMonth();
        } catch (\Throwable) {
            return $default->copy()->startOfMonth();
        }
    }
}
