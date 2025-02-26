<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    protected $guarded = [];

    public function request(){
        return $this->belongsTo(AssetRequest::class , 'request_id' , 'id');
    }


}
