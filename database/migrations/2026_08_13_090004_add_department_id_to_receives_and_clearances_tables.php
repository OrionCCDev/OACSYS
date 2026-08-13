<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('receives', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
        });
        Schema::table('clearances', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('receives', function (Blueprint $table) {
            $table->dropConstrainedForeignId('department_id');
        });
        Schema::table('clearances', function (Blueprint $table) {
            $table->dropConstrainedForeignId('department_id');
        });
    }
};
