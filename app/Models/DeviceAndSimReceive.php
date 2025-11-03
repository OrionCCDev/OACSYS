<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAndSimReceive extends Model
{
    protected $table = 'device_and_sim_receives';
    protected $guarded = [];

    // Relationships
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function simCard()
    {
        return $this->belongsTo(SimCard::class);
    }

    public function receive()
    {
        return $this->belongsTo(Receive::class);
    }
}
