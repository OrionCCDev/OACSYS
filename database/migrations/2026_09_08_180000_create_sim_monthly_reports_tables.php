<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Saved monthly SIM reports.
     *
     * Until now the report was a live view: re-opening August in December
     * showed December's data under an August heading. A report that gets
     * printed and signed has to stay what it was, so confirming a month
     * copies its rows here and they never move again.
     *
     * Lines are stored flat rather than as links to internet_sims. That is
     * the point - editing a line, or deleting it, must not change a report
     * that was already issued. internet_sim_id is kept only as a breadcrumb
     * back to the live record.
     *
     * A month can hold more than one report: making a fresh one keeps the
     * earlier as history rather than overwriting it, so `sequence` numbers
     * them 1, 2, 3 within the month.
     */
    public function up(): void
    {
        Schema::create('sim_monthly_reports', function (Blueprint $table) {
            $table->id();
            $table->date('report_month');           // always the 1st of the month
            $table->unsignedInteger('sequence')->default(1);

            $table->unsignedInteger('line_count')->default(0);
            $table->unsignedInteger('active_count')->default(0);
            $table->unsignedInteger('inactive_count')->default(0);

            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['report_month', 'sequence']);
            $table->index('report_month');
        });

        Schema::create('sim_monthly_report_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sim_monthly_report_id')->constrained()->cascadeOnDelete();

            // A breadcrumb only. The values below are the record.
            $table->foreignId('internet_sim_id')->nullable();

            $table->unsignedInteger('sl_no');
            $table->string('sim_number')->nullable();
            $table->string('sim_provider')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_site')->nullable();
            $table->boolean('line_active')->default(true);
            $table->string('sim_serial')->nullable();
            $table->string('contract_no')->nullable();
            $table->string('router_serial')->nullable();
            $table->string('remark')->nullable();

            $table->index(['sim_monthly_report_id', 'sl_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sim_monthly_report_lines');
        Schema::dropIfExists('sim_monthly_reports');
    }
};
