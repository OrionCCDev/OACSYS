<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Employee extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [];

    protected $casts = [
        'registration_pending' => 'boolean',
    ];

    protected static function booted(): void
    {
        // Recorded in a hurry with no Orion ID; once HR gives them one, they
        // are registered like anybody else.
        static::saving(function (Employee $employee) {
            if ($employee->registration_pending && filled($employee->employee_id)) {
                $employee->registration_pending = false;
            }
        });
    }

    public function devices(){
        return $this->hasMany(Device::class);
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function position(){
        return $this->belongsTo(Position::class);
    }
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function clearance(){
        return $this->hasMany(Clearance::class);
    }
    public function sim_card(){
        return $this->hasMany(SimCard::class);
    }
    public function receives(){
        return $this->hasMany(Receive::class);
    }
    public function requests(){
        return $this->hasMany(Request::class);
    }
    public function manage_project(){
        return $this->hasOne(Project::class , 'id' , 'project_manager_id');
    }
    public function manage_department(){
        return $this->hasOne(Department::class , 'id' , 'department_manager_id');
    }
    public function manager(){
        return $this->belongsTo(Employee::class , 'manager_id' , 'id');
    }
    public function my_employees(){
        return $this->hasMany(Employee::class , 'manager_id' , 'id');
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('employee_image');
    }
}
