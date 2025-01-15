<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_name')->nullable();//
            $table->string('device_code')->unique();
            $table->string('device_type')->nullable();//
            $table->string('device_price')->nullable();//
            $table->string('device_model')->nullable();//
            $table->text('short_description')->nullable();//
            $table->string('main_image')->default('default_device.png');//
            $table->string('serial_number')->nullable();
            $table->string('supplier_name')->nullable();//
            $table->enum('stored_at',['office','server','store','delivered']);//
            //	enum('New', 'Mediam_use', 'Bad_use', 'Scrap', 'Nee
            $table->enum('health',['New','Mediam_use','Bad_use','Scrap','Need_fix']);//

            // $table->string('count')->nullable();
            // $table->string('available_count')->nullable();
            $table->enum('status', ['available','taken','pending-receiving','pending-cancel'])->comment('available is mean not used by employee or client or consultant,taken')->default('available');
            $table->text('notes')->nullable();//
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
