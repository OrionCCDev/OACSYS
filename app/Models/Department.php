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
}
