<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    protected $casts = [
        'released_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function printer()
    {
        return $this->belongsTo(Printer::class);
    }
}
