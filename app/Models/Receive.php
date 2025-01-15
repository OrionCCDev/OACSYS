<?php

namespace App\Models;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Receive extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $guarded = [];


    public static function boot()
    {
        parent::boot();
        static::creating(function ($receive) {
            $receive->code = self::generateUniqueCode();
        });
    }

    public static function generateUniqueCode()
    {
        do
        { $code = Str::upper(Str::random(10)); }
        while (self::where('code', $code)->exists());
        return $code;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function clientEmployee()
    {
        return $this->belongsTo(ClientEmployee::class);
    }
    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
    public function SimCards()
    {
        return $this->hasMany(SimCard::class);
    }
}
