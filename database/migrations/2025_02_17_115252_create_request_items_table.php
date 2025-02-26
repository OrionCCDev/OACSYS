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
        Schema::create('request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained()->onDelete('cascade');
            $table->string('item_type'); // laptop, pc, sim_card, screen, mouse, hd
            $table->integer('quantity')->default(1);
            $table->enum('request_for_type' , ['employee', 'project' , 'consultant' , 'client' , 'other']);
            $table->string('requested_for_id')->nullable();
            $table->string('requested_for_name')->nullable();
            $table->string('requested_for_position')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_items');
    }
};
