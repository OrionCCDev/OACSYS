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
}
