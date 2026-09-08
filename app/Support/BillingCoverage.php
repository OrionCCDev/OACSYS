<?php

namespace App\Support;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

/**
 * Compares a printer's rental window against the periods its invoices cover.
 *
 * Printers are billed by quarter, but a final invoice is often short because
 * the project ended and the printer was transferred or cancelled early. That
 * makes "is every month of this rental actually invoiced?" the question the
 * reports need to answer, and it is not one you can eyeball off a list of
 * dates once a printer has moved between projects a few times.
 *
 * Periods are treated as inclusive of both endpoints: an invoice for
 * 01 Jan - 31 Mar covers the whole of those three months, and an invoice
 * starting 01 Apr continues it with no gap.
 */
class BillingCoverage
{
    /** @var array<int, array{start: CarbonInterface, end: CarbonInterface}> */
    public array $covered = [];

    /** @var array<int, array{start: CarbonInterface, end: CarbonInterface}> */
    public array $gaps = [];

    /** @var array<int, array{start: CarbonInterface, end: CarbonInterface}> */
    public array $overlaps = [];

    public int $windowDays = 0;
    public int $coveredDays = 0;

    public function __construct(
        public ?CarbonInterface $windowStart,
        public ?CarbonInterface $windowEnd,
        Collection $invoices
    ) {
        if (!$windowStart || !$windowEnd || $windowEnd->lt($windowStart)) {
            return;
        }

        $this->windowDays = $windowStart->diffInDays($windowEnd) + 1;

        $periods = $invoices
            ->filter(fn ($i) => $i->start_date && $i->end_date && $i->end_date->gte($i->start_date))
            ->map(fn ($i) => ['start' => $i->start_date->copy(), 'end' => $i->end_date->copy()])
            ->sortBy(fn ($p) => $p['start']->timestamp)
            ->values();

        $this->overlaps = $this->findOverlaps($periods);
        $this->covered = $this->merge($periods);
        $this->gaps = $this->gapsWithin($this->covered, $windowStart, $windowEnd);
        $this->coveredDays = $this->daysWithin($this->covered, $windowStart, $windowEnd);
    }

    public static function for($printer, ?Collection $invoices = null): self
    {
        [$start, $end] = $printer->rentalWindow();

        return new self($start, $end, $invoices ?? $printer->invoices);
    }

    /**
     * Coverage across a whole set of printers - used for the project report,
     * where the window spans from the earliest rental start to the latest end.
     */
    public static function across(Collection $printers): self
    {
        $windows = $printers->map(fn ($p) => $p->rentalWindow());

        return new self(
            $windows->map(fn ($w) => $w[0])->filter()->min(),
            $windows->map(fn ($w) => $w[1])->filter()->max(),
            $printers->flatMap(fn ($p) => $p->invoices)
        );
    }

    public function percentCovered(): int
    {
        return $this->windowDays > 0
            ? (int) round($this->coveredDays / $this->windowDays * 100)
            : 0;
    }

    public function uncoveredDays(): int
    {
        return max(0, $this->windowDays - $this->coveredDays);
    }

    public function isFullyCovered(): bool
    {
        return $this->windowDays > 0 && $this->gaps === [];
    }

    /** Merge overlapping and back-to-back periods into continuous stretches. */
    private function merge(Collection $periods): array
    {
        $merged = [];

        foreach ($periods as $period) {
            $last = end($merged);

            // A period starting the day after the last one ends continues it.
            if ($last && $period['start']->lte($last['end']->copy()->addDay())) {
                if ($period['end']->gt($last['end'])) {
                    $merged[array_key_last($merged)]['end'] = $period['end'];
                }
                continue;
            }

            $merged[] = $period;
        }

        return $merged;
    }

    /** Stretches billed by more than one invoice - usually a data-entry slip. */
    private function findOverlaps(Collection $periods): array
    {
        $overlaps = [];

        foreach ($periods as $i => $period) {
            foreach ($periods->slice($i + 1) as $other) {
                if ($other['start']->gt($period['end'])) {
                    break; // sorted by start, so nothing later can overlap either
                }

                $overlaps[] = [
                    'start' => $other['start'],
                    'end' => $period['end']->lt($other['end']) ? $period['end'] : $other['end'],
                ];
            }
        }

        return $overlaps;
    }

    private function gapsWithin(array $covered, CarbonInterface $start, CarbonInterface $end): array
    {
        $gaps = [];
        $cursor = $start->copy();

        foreach ($covered as $period) {
            if ($period['end']->lt($cursor)) {
                continue;
            }

            if ($period['start']->gt($cursor)) {
                $gapEnd = $period['start']->copy()->subDay();
                if ($gapEnd->gt($end)) {
                    $gapEnd = $end->copy();
                }
                $gaps[] = ['start' => $cursor->copy(), 'end' => $gapEnd];
            }

            $cursor = $period['end']->copy()->addDay();
            if ($cursor->gt($end)) {
                return $gaps;
            }
        }

        if ($cursor->lte($end)) {
            $gaps[] = ['start' => $cursor, 'end' => $end->copy()];
        }

        return $gaps;
    }

    private function daysWithin(array $covered, CarbonInterface $start, CarbonInterface $end): int
    {
        $days = 0;

        foreach ($covered as $period) {
            $from = $period['start']->lt($start) ? $start : $period['start'];
            $to = $period['end']->gt($end) ? $end : $period['end'];

            if ($to->gte($from)) {
                $days += $from->diffInDays($to) + 1;
            }
        }

        return $days;
    }
}
