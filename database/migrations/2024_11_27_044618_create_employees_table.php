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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->nullable();
            $table->string('name')->nullable();
            $table->string('profile_image')->default('default_employee.png');
            $table->string('orion_email')->nullable()->unique();
            $table->string('personal_mobile')->nullable();
            $table->string('personal_email')->nullable();
            $table->enum('type' , ['owner' , 'manager' , 'employee' , 'labor' , 'resigned'])->default('employee');
            $table->text('notes')->nullable();
            $table->timestamp('hire_date')->nullable();
            $table->timestamp('resign_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
