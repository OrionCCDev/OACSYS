<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Client extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];


    public function client_employees(){
        return $this->hasMany(ClientEmployee::class , 'client_id' , 'id');
    }
    public function projects(){
        return $this->hasMany(Project::class);
    }
}
