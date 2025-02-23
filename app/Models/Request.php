<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $guarded = [];

    public function items(){
        return $this->hasMany(RequestItem::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
