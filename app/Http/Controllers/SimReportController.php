<?php

namespace App\Http\Controllers;

use App\Models\InternetSim;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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
            'signatory' => $this->itManagerName(),
        ]);
    }

    /** The same sheet as a PDF, for signing and filing. */
    public function monthlyPdf(Request $request)
    {
        $month = $this->resolveMonth($request->input('month'));

        $pdf = Pdf::loadView('sim-report.monthly-pdf', [
            'month' => $month,
            'sims' => $this->simsFor($month),
            'signatory' => $this->itManagerName(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('sim-report-' . $month->format('Y-m') . '.pdf');
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

    /**
     * Who signs the sheet off. Users hold the roles and point at their
     * employee record, so the lookup starts from the user side.
     */
    private function itManagerName(): ?string
    {
        $user = User::whereHas('roles', fn ($q) => $q->whereIn('name', ['o-super-admin', 'o-admin']))
            ->with('employee')
            ->orderBy('id')
            ->first();

        return $user?->employee?->name ?? $user?->name;
    }
}
