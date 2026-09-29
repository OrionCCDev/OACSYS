<?php

namespace App\Models\Concerns;

use App\Models\User;

/**
 * For records that are normally closed with a signed paper but can be
 * closed without one: who did that, and when.
 */
trait ForceClosable
{
    public function initializeForceClosable(): void
    {
        $this->mergeCasts(['force_closed_at' => 'datetime']);
    }

    public function forceClosedBy()
    {
        return $this->belongsTo(User::class, 'force_closed_by');
    }

    public function wasForceClosed(): bool
    {
        return $this->force_closed_at !== null;
    }
}
