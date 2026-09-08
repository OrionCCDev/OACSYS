<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A printer record is rental history - the PO it came in under, the
     * invoices raised against it, and its place in a transfer chain. Deleting
     * one outright tore all of that out, so deletion is now reversible: the
     * row (and its invoices, which are only cascaded by the database on a
     * real delete) stays put and simply drops out of every listing.
     */
    public function up(): void
    {
        Schema::table('printers', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('printers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
