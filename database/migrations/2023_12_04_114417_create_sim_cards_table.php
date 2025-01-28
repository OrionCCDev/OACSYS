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
        Schema::create('sim_cards', function (Blueprint $table) {
            $table->id();
            $table->string('sim_number')->nullable();
            $table->string('sim_serial')->nullable();
            $table->string('sim_plan')->default('Business Mobile Plan 50');
            $table->string('sim_provider')->default('DU');
            $table->enum('status',['available','taken','pending-receive','pending-cancel'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sim_cards');
    }
};
