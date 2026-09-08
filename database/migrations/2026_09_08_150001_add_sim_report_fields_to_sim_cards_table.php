<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The columns the monthly site-internet SIM report needs.
     *
     * account_name  - who the line is registered to with the provider
     *                 ("Eng. Saqer", "Orion"). Free text: an account holder is
     *                 not always an employee record.
     * contract_no   - the provider's contract reference.
     * line_active   - whether the line is live with the provider. This is a
     *                 different question from the existing status column,
     *                 which tracks assignment (available / taken / pending).
     *                 A SIM can be sitting in stock with a live line, or be
     *                 assigned to someone with the line suspended.
     * remark        - the report's free-text remark column ("CAMERA SYS",
     *                 "STOCK", "WAS 246").
     * router_id     - the router this SIM is fitted in. Separate from the
     *                 existing device_id, which still pairs a SIM with a
     *                 device such as a CCTV camera.
     */
    public function up(): void
    {
        Schema::table('sim_cards', function (Blueprint $table) {
            $table->string('account_name')->nullable()->after('sim_provider');
            $table->string('contract_no')->nullable()->after('account_name');
            $table->boolean('line_active')->default(true)->after('status');
            $table->string('remark')->nullable()->after('notes');
            $table->foreignId('router_id')->nullable()->after('device_id')->constrained('routers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sim_cards', function (Blueprint $table) {
            $table->dropConstrainedForeignId('router_id');
            $table->dropColumn(['account_name', 'contract_no', 'line_active', 'remark']);
        });
    }
};
