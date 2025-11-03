<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function consultants(){
        return $this->hasMany(Consultant::class);
    }
    public function clients(){
        return $this->hasMany(ClientEmployee::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function devices(){
        return $this->hasMany(Device::class);
    }
    public function employees(){
        return $this->hasMany(Employee::class);
    }
    public function manager(){
        return $this->hasOne(Employee::class , 'id' , 'project_manager_id');
    }

    // Project asset management relationships
    public function receives(){
        return $this->hasMany(Receive::class);
    }

    public function simCards(){
        return $this->hasMany(SimCard::class);
    }

    // Transfers from this project
    public function transfersFrom(){
        return $this->hasMany(ProjectAssetTransfer::class, 'from_project_id');
    }

    // Transfers to this project
    public function transfersTo(){
        return $this->hasMany(ProjectAssetTransfer::class, 'to_project_id');
    }

    // Get all assets (devices and sim cards) for this project
    public function getAllAssets()
    {
        return [
            'devices' => $this->devices()->get(),
            'sim_cards' => $this->simCards()->get()
        ];
    }

    // Get assets count
    public function getAssetsCount()
    {
        return [
            'devices' => $this->devices()->count(),
            'sim_cards' => $this->simCards()->count(),
            'total' => $this->devices()->count() + $this->simCards()->count()
        ];
    }
}
