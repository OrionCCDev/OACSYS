<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printer extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function clientEmployee()
    {
        return $this->belongsTo(ClientEmployee::class);
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class)->orderByDesc('start_date');
    }

    /**
     * The prior project engagement this printer's rental continued from, if
     * it was transferred in rather than freshly received.
     */
    public function transferredFrom()
    {
        return $this->belongsTo(Printer::class, 'transferred_from_id')->withTrashed();
    }

    /**
     * The new project engagement this printer's rental continued into, once
     * transferred - null while status is still active/cancelled.
     */
    public function transferredTo()
    {
        return $this->hasOne(Printer::class, 'transferred_from_id')->withTrashed();
    }

    /**
     * Every project engagement of this physical printer, oldest first.
     *
     * A transfer creates a new row rather than editing this one, so the
     * machine on your floor is a chain of records, not a single one. Walking
     * it in both directions from any link gives the whole asset's life.
     * Soft-deleted links are included so a deleted record can't silently
     * shorten the history.
     */
    public function lifecycleChain()
    {
        $first = $this;
        $seen = [$this->id => true];
        while ($first->transferred_from_id && ($prev = $first->transferredFrom) && !isset($seen[$prev->id])) {
            $seen[$prev->id] = true;
            $first = $prev;
        }

        $chain = collect([$first]);
        $current = $first;
        while (($next = $current->transferredTo) && !isset($seen[$next->id])) {
            $seen[$next->id] = true;
            $chain->push($next);
            $current = $next;
        }

        return $chain;
    }

    /**
     * The window this printer was actually on rent for on this project.
     *
     * An active printer has no end date, so it is still running: count it up
     * to today. A transfer records the handover date as this engagement's
     * end_date AND as the next one's start_date, so the last day here belongs
     * to the next project - counting it on both would report a one-day
     * billing gap on every printer that has ever moved. A cancelled printer's
     * end_date is genuinely its last day on rent, so that one is inclusive.
     */
    public function rentalWindow(): array
    {
        $end = $this->end_date;

        if ($end && $this->status === 'transferred') {
            $end = $end->copy()->subDay();
        }

        return [$this->start_date, $end ?? now()->startOfDay()];
    }

    /** Big / Small, as split on the monthly report. */
    public function sizeLabel(): string
    {
        return match ($this->size) {
            'big' => 'Big',
            'small' => 'Small',
            default => 'Not set',
        };
    }

    /**
     * Where the printer sits, in the words used on site. Falls back to who it
     * is assigned to when nobody has written anything more specific.
     */
    public function designationLabel(): string
    {
        if (filled($this->designation)) {
            return $this->designation;
        }

        return match ($this->delivered_to_type) {
            'client' => 'Client Office',
            'consultant' => 'Consultant Office',
            'office' => 'Orion Office',
            default => '-',
        };
    }

    /**
     * The rental period as shown in the reports. Built from rentalWindow() so
     * the dates on screen always agree with the day counts beside them.
     */
    public function rentalPeriodLabel(string $format = 'd M Y'): string
    {
        [$start, $end] = $this->rentalWindow();

        return $start->format($format) . ' - ' . ($this->end_date ? $end->format($format) : 'ongoing');
    }

    /**
     * Who the printer is assigned to within this project - a client, a
     * consultant, or Orion itself.
     */
    public function assignedToLabel(): string
    {
        return match ($this->delivered_to_type) {
            'client' => $this->clientEmployee->name ?? 'Unknown Client',
            'consultant' => $this->consultant->name ?? 'Unknown Consultant',
            'office' => 'Orion',
            default => 'Unknown',
        };
    }

    /**
     * Close this printer out (its rental moved on to a new project) and
     * create the new project's printer record, carrying over its identity
     * (name/model/serial/supplier/image) and linking back via
     * transferred_from_id so the full chain stays traceable.
     */
    public function transferToProject(
        int $projectId,
        string $poNumber,
        string $deliveredToType,
        ?int $deliveredToTargetId,
        string $startDate,
        ?string $poDocument = null,
        ?string $notes = null
    ): self {
        $this->update([
            'status' => 'transferred',
            'end_date' => $startDate,
        ]);

        return self::create([
            'project_id' => $projectId,
            'supplier_id' => $this->supplier_id,
            'po_number' => $poNumber,
            'po_document' => $poDocument,
            'name' => $this->name,
            'model' => $this->model,
            'size' => $this->size,
            'serial_number' => $this->serial_number,
            'main_image' => $this->main_image,
            'delivered_to_type' => $deliveredToType,
            'client_employee_id' => $deliveredToType === 'client' ? $deliveredToTargetId : null,
            'consultant_id' => $deliveredToType === 'consultant' ? $deliveredToTargetId : null,
            'status' => 'active',
            'start_date' => $startDate,
            // designation is deliberately not carried over: it describes where
            // the printer sat on the previous project, not the new one.
            'transferred_from_id' => $this->id,
            'notes' => $notes,
        ]);
    }

    /**
     * End this printer's rental entirely - returned to the supplier, not
     * continuing on any project.
     */
    public function cancel(string $endDate, ?string $notes = null): void
    {
        $this->update([
            'status' => 'cancelled',
            'end_date' => $endDate,
            'notes' => $notes ?? $this->notes,
        ]);
    }
}
