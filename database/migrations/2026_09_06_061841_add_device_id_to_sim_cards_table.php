<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sim_cards', function (Blueprint $table) {
            // Unique so a device only ever holds one SIM at a time - matches the
            // single SIM slot on the routers/cameras this is meant to track.
            $table->foreignId('device_id')->nullable()->unique()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sim_cards', function (Blueprint $table) {
            $table->dropConstrainedForeignId('device_id');
        });
    }
};
