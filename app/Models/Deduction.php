<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Deduction extends Model
{
    protected $fillable = [
        'employee_id',
        'device_id',
        'reason',
        'amount',
        'description'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class , 'employee_id' , 'id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
