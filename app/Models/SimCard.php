<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimCard extends Model
{
    protected $guarded = [];

    public function consultant(){
        return $this->belongsTo(Consultant::class);
    }

    public function clientEmployee(){
        return $this->belongsTo(ClientEmployee::class);
    }
    public function clearances()
    {
        return $this->belongsToMany(Clearance::class , 'device_and_sim_clearances' , 'sim_card_id' ,'clearance_id' ,'id' ,'id' );
    }
    public function receives()
    {
        return $this->belongsToMany(Receive::class , 'device_and_sim_receives' , 'receive_id' , 'sim_card_id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function device(){
        return $this->belongsTo(Device::class);
    }

    /**
     * Truly free: no employee/consultant/client/device holding it, and not
     * mid some other process (pending-receive etc). status alone isn't
     * trustworthy on its own since older code paths can leave it out of sync
     * with the assignment columns.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
            ->whereNull('employee_id')
            ->whereNull('consultant_id')
            ->whereNull('client_employee_id')
            ->whereNull('device_id');
    }
}
