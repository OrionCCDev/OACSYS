<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A monthly SIM report as it was issued: a frozen copy of the lines, kept so
 * a printed and signed sheet can always be produced again unchanged.
 *
 * More than one can exist for a month. Making a new one keeps the earlier as
 * history; `sequence` orders them within the month.
 */
class SimMonthlyReport extends Model
{
    protected $guarded = [];

    protected $casts = [
        'report_month' => 'date',
    ];

    public function lines()
    {
        return $this->hasMany(SimMonthlyReportLine::class)->orderBy('sl_no');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** "AUG 2026", as the sheet heads itself. */
    public function monthLabel(): string
    {
        return strtoupper($this->report_month->format('M Y'));
    }

    /** Only shown once a month has more than one, to avoid noise. */
    public function versionLabel(): string
    {
        return $this->sequence > 1 ? 'v' . $this->sequence : '';
    }
}
