<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A site internet SIM line - the data lines behind site routers and cameras.
 *
 * Kept separate from SimCard, which is the IT asset register (issued to
 * people, cleared, received). These are provider accounts: who the line is
 * registered to, its contract, whether it is live, and which router it sits
 * in.
 *
 * account_site is free text: the sheet records places like "Eng. Fayez Flat",
 * "ATEIA HOME" and "Orion Farm", which are not employees, departments or
 * projects in this system.
 */
class InternetSim extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'line_active' => 'boolean',
    ];

    public function router()
    {
        return $this->belongsTo(Router::class);
    }

    /** The report's "Account Site" - where the line was delivered. */
    public function siteLabel(): string
    {
        return filled($this->account_site) ? $this->account_site : 'Unassigned';
    }

    /** Live with the provider, which is separate from where it sits. */
    public function lineStatusLabel(): string
    {
        return $this->line_active ? 'active' : 'NOT active';
    }
}
