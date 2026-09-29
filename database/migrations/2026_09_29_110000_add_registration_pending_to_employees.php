<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Somebody can be handed a laptop on their first day, before HR has put
 * them in the system. They are recorded with just a name, email and mobile,
 * and this marks the record as one still waiting for the rest.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('employees', 'registration_pending')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->boolean('registration_pending')->default(false);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('employees', 'registration_pending')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->dropColumn('registration_pending');
            });
        }
    }
};
