<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Employee extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [];

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
    public function manage_project(){
        return $this->hasOne(Project::class , 'id' , 'project_manager_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('employee_image');
    }
}
