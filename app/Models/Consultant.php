<?php

namespace App\Models;

use App\Models\Device;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function devices(){
        return $this->hasMany(Device::class);
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
}
