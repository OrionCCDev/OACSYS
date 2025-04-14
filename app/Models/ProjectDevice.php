<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDevice extends Model
{
    protected $table = 'project_devices';
    protected $guarded = [];

    public function devices()
    {
        return $this->hasMany(Device::class , 'device_id' , 'id');
    }
}
