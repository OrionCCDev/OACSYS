<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A site internet SIM line - the data lines behind site routers and cameras.
 *
 * Kept separate from SimCard, which is the IT asset register (issued to
 * people, cleared, received). These are provider accounts: who the line is
 * registered to, its contract, whether it is live, and which router it sits
 * in.
 */
class InternetSim extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'line_active' => 'boolean',
    ];

    public function router()
    {
        return $this->belongsTo(Router::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
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

    /**
     * The report's "Account Site" - who the line was delivered to. At most one
     * holder column is ever set, so the first found is the answer.
     */
    public function holderLabel(): string
    {
        return $this->employee?->name
            ?? $this->department?->name
            ?? $this->project?->project_name
            ?? $this->clientEmployee?->name
            ?? $this->consultant?->name
            ?? 'Unassigned';
    }

    public function holderType(): string
    {
        return match (true) {
            (bool) $this->employee_id => 'Employee',
            (bool) $this->department_id => 'Department',
            (bool) $this->project_id => 'Project',
            (bool) $this->client_employee_id => 'Client',
            (bool) $this->consultant_id => 'Consultant',
            default => '-',
        };
    }

    /** Live with the provider, which is separate from who holds it. */
    public function lineStatusLabel(): string
    {
        return $this->line_active ? 'active' : 'NOT active';
    }

    /** Clears every holder column, so only one is ever set at a time. */
    public function clearHolders(): array
    {
        return [
            'employee_id' => null,
            'department_id' => null,
            'project_id' => null,
            'client_employee_id' => null,
            'consultant_id' => null,
        ];
    }
}
