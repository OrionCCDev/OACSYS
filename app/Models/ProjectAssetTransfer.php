<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProjectAssetTransfer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'transferred_at' => 'datetime',
    ];

    // Relationships
    public function fromProject()
    {
        return $this->belongsTo(Project::class, 'from_project_id');
    }

    public function toProject()
    {
        return $this->belongsTo(Project::class, 'to_project_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function simCard()
    {
        return $this->belongsTo(SimCard::class);
    }

    public function transferredBy()
    {
        return $this->belongsTo(Employee::class, 'transferred_by');
    }

    // Generate unique transfer code
    public static function generateUniqueCode()
    {
        do {
            $code = 'TRF-' . strtoupper(Str::random(10));
        } while (self::where('transfer_code', $code)->exists());

        return $code;
    }

    // Get asset type (device or sim card)
    public function getAssetType()
    {
        if ($this->device_id) {
            return 'device';
        } elseif ($this->sim_card_id) {
            return 'sim_card';
        }
        return null;
    }

    // Get the asset
    public function getAsset()
    {
        if ($this->device_id) {
            return $this->device;
        } elseif ($this->sim_card_id) {
            return $this->simCard;
        }
        return null;
    }
}
