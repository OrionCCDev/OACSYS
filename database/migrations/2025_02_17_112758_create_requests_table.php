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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_code')->unique();
            // $table->string('request_signed')->unique();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable();
            $table->enum('status' , ['pending', 'pending-approve' , 'approved', 'pending-receive' , 'rejected']); // pending, approved, rejected
            $table->boolean('is_read')->nullable();
            // $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
