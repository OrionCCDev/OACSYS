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
        Schema::create('device_and_sim_clearances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('sim_card_id')->nullable()->constrained('sim_cards' , 'id')->cascadeOnDelete();
            $table->foreignId('clearance_id')->nullable()->constrained('clearances' , 'id')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_and_sim_clearances');
    }
};
