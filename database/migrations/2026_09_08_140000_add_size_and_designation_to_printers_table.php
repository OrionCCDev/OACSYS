<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Two fields the monthly printers report is built from.
     *
     * size          - big or small, the split the report totals by.
     * designation   - where the printer actually sits, in the words used on
     *                 site ("Ground Floor", "Mwafaq & Hussain store"). Free
     *                 text on purpose: it is more specific than the
     *                 client/consultant/office assignment can express.
     *
     * Both are nullable because printers already exist without them. The
     * report shows a separate "Not set" line when any are still blank, so its
     * totals always reconcile rather than quietly under-counting.
     */
    public function up(): void
    {
        Schema::table('printers', function (Blueprint $table) {
            $table->enum('size', ['big', 'small'])->nullable()->after('model');
            $table->string('designation')->nullable()->after('delivered_to_type');
        });
    }

    public function down(): void
    {
        Schema::table('printers', function (Blueprint $table) {
            $table->dropColumn(['size', 'designation']);
        });
    }
};
