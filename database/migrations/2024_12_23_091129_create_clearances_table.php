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
        Schema::create('clearances', function (Blueprint $table) {
            $table->id();
            $table->string('clear_code')->unique()->nullable();
            $table->string('clear_image')->nullable();
            $table->enum('status' , ['pending' , 'finished']);
            $table->foreignId('employee_id')->constrained()->nullOnDelete();
            $table->foreignId('client_employee_id')->constrained('client_employees' , 'id')->nullOnDelete();
            $table->foreignId('consultant_id')->constrained()->nullOnDelete();
            // $table->foreignId('device_id')->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clearances');
    }
};
