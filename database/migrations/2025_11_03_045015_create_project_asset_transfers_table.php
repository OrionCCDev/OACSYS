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
        Schema::create('project_asset_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_code')->unique();
            $table->foreignId('from_project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('to_project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('device_id')->nullable()->constrained('devices')->onDelete('cascade');
            $table->foreignId('sim_card_id')->nullable()->constrained('sim_cards')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->string('transfer_image')->nullable(); // Signature image for transfer
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->timestamp('transferred_at')->nullable();
            $table->foreignId('transferred_by')->nullable()->constrained('employees')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_asset_transfers');
    }
};
