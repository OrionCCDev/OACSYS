<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetRequest extends Model
{
    protected $guarded = [];

    protected $table = 'requests';

    public function items(){
        return $this->hasMany(RequestItem::class , 'request_id' , 'id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

}
