<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrinterAssignment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function clientEmployee()
    {
        return $this->belongsTo(ClientEmployee::class);
    }

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(Employee::class, 'assigned_by');
    }

    /**
     * Human-readable "where" for this assignment period - project name,
     * client name, consultant name, or "Our Office".
     */
    public function locationLabel(): string
    {
        return match ($this->location_type) {
            'project' => $this->project->project_name ?? 'Unknown Project',
            'client' => $this->clientEmployee->name ?? 'Unknown Client',
            'consultant' => $this->consultant->name ?? 'Unknown Consultant',
            'office' => 'Our Office',
            default => 'Unknown',
        };
    }

    /**
     * Close out the printer's current open assignment (if any) and open a
     * new one - the single place that changes where a printer lives, used by
     * both the per-project "quick transfer" action and the full printer
     * report's reassignment form so the history table can't drift out of
     * sync with Device's own project/client/consultant columns.
     */
    public static function reassign(
        Device $device,
        string $locationType,
        ?int $targetId,
        string $startDate,
        ?int $assignedBy = null,
        ?string $notes = null
    ): self {
        $current = $device->currentAssignment;
        if ($current) {
            $current->update(['end_date' => $startDate]);
        }

        $attributes = [
            'device_id' => $device->id,
            'location_type' => $locationType,
            'project_id' => null,
            'client_employee_id' => null,
            'consultant_id' => null,
            'start_date' => $startDate,
            'end_date' => null,
            'notes' => $notes,
            'assigned_by' => $assignedBy,
        ];

        match ($locationType) {
            'project' => $attributes['project_id'] = $targetId,
            'client' => $attributes['client_employee_id'] = $targetId,
            'consultant' => $attributes['consultant_id'] = $targetId,
            'office' => null,
        };

        $assignment = self::create($attributes);

        $device->update([
            'project_id' => $locationType === 'project' ? $targetId : null,
            'client_id' => $locationType === 'client' ? $targetId : null,
            'consultant_id' => $locationType === 'consultant' ? $targetId : null,
            'stored_at' => $locationType === 'office' ? 'office' : 'delivered',
        ]);

        return $assignment;
    }
}
