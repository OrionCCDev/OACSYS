<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function consultants(){
        return $this->hasMany(Consultant::class);
    }
    public function clients(){
        return $this->hasMany(ClientEmployee::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function devices(){
        return $this->hasMany(Device::class);
    }
    public function employees(){
        return $this->hasMany(Employee::class);
    }
    public function manager(){
        return $this->hasOne(Employee::class , 'id' , 'project_manager_id');
    }
}
