<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAndSimClearance extends Model
{
    protected $table = 'device_and_sim_clearances';
    protected $guarded = [];
    public $timestamps = false;

    // Relationships
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function simCard()
    {
        return $this->belongsTo(SimCard::class);
    }

    public function clearance()
    {
        return $this->belongsTo(Clearance::class);
    }
}
