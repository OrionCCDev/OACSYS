<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public function employess(){
        return $this->hasMany(Employee::class);
    }
    public function positions(){
        return $this->hasMany(Position::class);
    }

    public function manager(){
        return $this->hasOne(Employee::class, 'id', 'department_manager_id');
    }

    public function devices(){
        return $this->hasMany(Device::class);
    }

    public function simCards(){
        return $this->hasMany(SimCard::class);
    }

    public function receives(){
        return $this->hasMany(Receive::class);
    }

    public function clearances(){
        return $this->hasMany(Clearance::class);
    }
}
