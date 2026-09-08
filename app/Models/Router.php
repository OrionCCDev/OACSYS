<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Router extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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

    /** The SIM cards fitted in this router. */
    public function simCards()
    {
        return $this->hasMany(SimCard::class);
    }

    /**
     * Who currently holds the router. At most one of the holder columns is
     * set, so the first one found is the answer.
     */
    public function holder(): ?Model
    {
        return $this->employee
            ?? $this->department
            ?? $this->project
            ?? $this->clientEmployee
            ?? $this->consultant;
    }

    /**
     * Where the router sits, as the SIM report's "Account Site" column shows
     * it - a person, a department, or a project.
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
