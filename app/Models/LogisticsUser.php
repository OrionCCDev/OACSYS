<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogisticsUser extends Model
{
    protected $table = 'logistics_users';

    protected $fillable = ['name', 'email', 'password', 'password_hint', 'logistic_role', 'user_id'];

    protected $hidden = ['password', 'password_hint'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
