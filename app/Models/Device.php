<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;


class Device extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
    public function consultant(){
        return $this->belongsTo(Consultant::class);
    }
    public function clientEmployee(){
        return $this->belongsTo(ClientEmployee::class ,'client_id' , 'id');
    }
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function receive(){
        return $this->belongsTo(Receive::class);
    }
    public function clearances()
    {
        return $this->belongsToMany(Clearance::class , 'device_and_sim_clearances' , 'device_id' ,'clearance_id' , 'id' , 'id');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('Device_image');
    }
}
