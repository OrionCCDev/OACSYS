<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A site internet router, tracked separately from devices.
 *
 * Its ISP and the site it sits at are free text on purpose: routers come from
 * the internet provider rather than the suppliers list, and sites on the sheet
 * include places like "Eng. Fayez Flat" and "Orion Farm" that no picker of
 * employees, departments or projects could express.
 */
class Router extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /** The site internet SIM lines fitted in this router. */
    public function simCards()
    {
        return $this->hasMany(InternetSim::class);
    }

    /**
     * The SIM the combined add/edit form works on. A router normally holds
     * one; if a second is ever added from the Internet SIMs page, the form
     * keeps editing the original rather than silently switching.
     */
    public function primarySim(): ?InternetSim
    {
        return $this->simCards()->orderBy('id')->first();
    }

    public function siteLabel(): string
    {
        return filled($this->account_site) ? $this->account_site : 'Unassigned';
    }
}
