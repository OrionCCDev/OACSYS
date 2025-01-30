<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class Clearance extends Model
{
    protected $guarded = [];


    public static function boot()
    {
        parent::boot();
        static::creating(function ($clearance) {
            $clearance->clear_code = self::generateUniqueCode();
        });
    }

    public static function generateUniqueCode()
    {
        do
        { $clear_code = Str::upper(Str::random(10)); }
        while (self::where('clear_code', $clear_code)->exists());
        return $clear_code;
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class , 'device_and_sim_clearances' , 'clearance_id' , 'device_id', 'id' , 'id');
    }

    public function simCards()
    {
        return $this->belongsToMany(SimCard::class , 'device_and_sim_clearances' , 'clearance_id' , 'sim_card_id', 'id' , 'id');
    }

    public function clientEmployee(){
        return $this->belongsTo(ClientEmployee::class , 'client_employee_id' , 'id');
    }
    public function consultant(){
        return $this->belongsTo(Consultant::class , 'consultant_id' , 'id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class , 'employee_id' , 'id');
    }
}
