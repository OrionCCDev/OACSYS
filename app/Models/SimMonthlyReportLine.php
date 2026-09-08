<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * One row of an issued monthly report. The values are copies, deliberately
 * not links: editing or deleting the live SIM must never alter a report that
 * has already gone out.
 */
class SimMonthlyReportLine extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'line_active' => 'boolean',
    ];

    public function report()
    {
        return $this->belongsTo(SimMonthlyReport::class, 'sim_monthly_report_id');
    }

    public function lineStatusLabel(): string
    {
        return $this->line_active ? 'active' : 'NOT active';
    }
}
