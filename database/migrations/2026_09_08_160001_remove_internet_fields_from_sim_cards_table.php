<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Takes the site-internet fields back off sim_cards.
     *
     * They were briefly added there, then moved to their own internet_sims
     * table so the two kinds of SIM stay separate: sim_cards is the IT asset
     * register, internet_sims is the site internet lines. Leaving these
     * columns behind would invite the same line being recorded in both
     * places and neither list agreeing with the report.
     *
     * Anything already typed into them is copied across before they go, so
     * nothing entered in the meantime is lost.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('sim_cards', 'account_name')) {
            return;
        }

        $rows = \DB::table('sim_cards')
            ->where(function ($q) {
                $q->whereNotNull('account_name')
                    ->orWhereNotNull('contract_no')
                    ->orWhereNotNull('remark')
                    ->orWhereNotNull('router_id');
            })
            ->get();

        foreach ($rows as $row) {
            \DB::table('internet_sims')->insert([
                'sim_number' => $row->sim_number ?? '-',
                'sim_provider' => $row->sim_provider ?? '-',
                'account_name' => $row->account_name,
                'sim_serial' => $row->sim_serial,
                'contract_no' => $row->contract_no,
                'line_active' => $row->line_active ?? 1,
                'router_id' => $row->router_id,
                'employee_id' => $row->employee_id,
                'department_id' => $row->department_id,
                'project_id' => $row->project_id,
                'client_employee_id' => $row->client_employee_id,
                'consultant_id' => $row->consultant_id,
                'remark' => $row->remark,
                'created_at' => $row->created_at,
                'updated_at' => now(),
            ]);
        }

        Schema::table('sim_cards', function (Blueprint $table) {
            $table->dropConstrainedForeignId('router_id');
            $table->dropColumn(['account_name', 'contract_no', 'line_active', 'remark']);
        });
    }

    public function down(): void
    {
        Schema::table('sim_cards', function (Blueprint $table) {
            $table->string('account_name')->nullable()->after('sim_provider');
            $table->string('contract_no')->nullable()->after('account_name');
            $table->boolean('line_active')->default(true)->after('status');
            $table->string('remark')->nullable()->after('notes');
            $table->foreignId('router_id')->nullable()->after('device_id')->constrained('routers')->nullOnDelete();
        });
    }
};
