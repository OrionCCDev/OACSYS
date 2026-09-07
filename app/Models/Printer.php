<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
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
        return $this->belongsTo(Printer::class, 'transferred_from_id');
    }

    /**
     * The new project engagement this printer's rental continued into, once
     * transferred - null while status is still active/cancelled.
     */
    public function transferredTo()
    {
        return $this->hasOne(Printer::class, 'transferred_from_id');
    }

    /**
     * Who/where within this project the printer is physically delivered to.
     */
    public function deliveredToLabel(): string
    {
        return match ($this->delivered_to_type) {
            'client' => $this->clientEmployee->name ?? 'Unknown Client',
            'consultant' => $this->consultant->name ?? 'Unknown Consultant',
            'office' => 'Our Office',
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
            'serial_number' => $this->serial_number,
            'main_image' => $this->main_image,
            'delivered_to_type' => $deliveredToType,
            'client_employee_id' => $deliveredToType === 'client' ? $deliveredToTargetId : null,
            'consultant_id' => $deliveredToType === 'consultant' ? $deliveredToTargetId : null,
            'status' => 'active',
            'start_date' => $startDate,
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
