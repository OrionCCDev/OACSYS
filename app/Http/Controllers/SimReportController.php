<?php

namespace App\Http\Controllers;

use App\Exports\InternetSimReportExport;
use App\Models\InternetSim;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * The monthly site-internet SIM report: every SIM line, who the account is
 * registered to, where it ended up, and the router it is fitted in.
 *
 * Read-only. Nothing here changes data, so the page can be handed to whoever
 * needs the numbers.
 */
class SimReportController extends Controller
{
    public function monthly(Request $request)
    {
        $month = $this->resolveMonth($request->input('month'));
        $sims = $this->simsFor($month);

        return view('sim-report.monthly', [
            'month' => $month,
            'sims' => $sims,
        ]);
    }

    /** The same sheet as a PDF, for signing and filing. */
    public function monthlyPdf(Request $request)
    {
        $month = $this->resolveMonth($request->input('month'));

        $pdf = Pdf::loadView('sim-report.monthly-pdf', [
            'month' => $month,
            'sims' => $this->simsFor($month),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('sim-report-' . $month->format('Y-m') . '.pdf');
    }

    /**
     * The same sheet as Excel, in the column order the importer reads.
     *
     * This is the month-to-month workflow: download the last report, change
     * what moved, upload it again on the Internet SIMs page. Rows are matched
     * on SIM number, account site and SIM S/N, so edits land on the right
     * lines and nothing is duplicated.
     */
    public function monthlyExcel(Request $request)
    {
        $month = $this->resolveMonth($request->input('month'));

        return Excel::download(
            new InternetSimReportExport($this->simsFor($month)),
            'sim-report-' . $month->format('Y-m') . '.xlsx'
        );
    }

    /**
     * SIMs as they stood at the end of the chosen month: anything recorded by
     * then, newest accounts last so the sheet reads in the order lines were
     * added. A SIM added later does not appear on an earlier month's report.
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

    /** Accepts YYYY-MM from the month picker; anything else means this month. */
    private function resolveMonth(?string $input): Carbon
    {
        try {
            return $input ? Carbon::createFromFormat('Y-m', $input)->startOfMonth() : Carbon::now()->startOfMonth();
        } catch (\Throwable) {
            return Carbon::now()->startOfMonth();
        }
    }

}
