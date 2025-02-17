<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $guarded = [];

    public function items(){
        return $this->hasMany(RequestItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
