<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * The status filter on a list page: which statuses exist, how many rows
 * each has, and which one the request is asking for.
 *
 * The labels come from the caller, in the order they should be shown. Any
 * status found in the table that the caller did not name is added after
 * them with a readable label, so a value introduced later still gets a
 * button instead of rows nobody can filter to.
 */
class StatusFilter
{
    /** @var array<string, string> status value => label */
    public array $statuses;

    /** @var array<string, int> status value => number of rows */
    public array $counts;

    public int $total;

    /** The status being filtered to, or null for everything. */
    public ?string $current;

    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $model
     * @param  array<string, string>  $labels
     */
    public function __construct(string $model, array $labels, Request $request)
    {
        $this->counts = $model::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->map(fn ($n) => (int) $n)
            ->all();

        $this->statuses = $labels;
        foreach (array_keys($this->counts) as $value) {
            if ($value !== '' && !isset($this->statuses[$value])) {
                $this->statuses[$value] = Str::headline($value);
            }
        }

        $this->total = array_sum($this->counts);

        // Only a status this list knows narrows it; a mistyped or stale
        // ?status= shows everything rather than an empty page.
        $asked = (string) $request->query('status', '');
        $this->current = isset($this->statuses[$asked]) ? $asked : null;
    }

    public function apply(Builder $query): Builder
    {
        return $this->current === null ? $query : $query->where('status', $this->current);
    }

    public function count(string $status): int
    {
        return $this->counts[$status] ?? 0;
    }

    public function label(?string $status): string
    {
        return $this->statuses[$status] ?? Str::headline((string) $status);
    }
}
