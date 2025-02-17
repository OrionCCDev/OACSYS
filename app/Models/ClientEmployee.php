<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ClientEmployee extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [];

    public function client(){
        return $this->belongsTo(Client::class , 'client_id' , 'id');
    }
    public function clearance(){
        return $this->hasMany(Clearance::class , 'client_employee_id' , 'id');
    }
    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function sim_card(){
        return $this->hasMany(SimCard::class);
    }

    public function devices(){
        return $this->hasMany(Device::class , 'client_id' , 'id');
    }
    public function receives(){
        return $this->hasMany(Receive::class);
    }
    // spatie media library collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('receives');
        $this->addMediaCollection('gallery');
    }
}
