<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Two corrections to how routers and internet SIMs describe themselves.
     *
     * account_site replaces the five holder foreign keys. The site sheet
     * records places like "Eng. Fayez Flat", "ATEIA HOME" and "Orion Farm" -
     * none of which are employees, departments or projects in this system, so
     * a picker could never express them. Free text is what the job needs.
     *
     * isp_provider replaces supplier_id on routers. These come from the
     * internet provider (Etisalat, DU), not from the suppliers list, which
     * exists for rental equipment.
     *
     * Any holder or supplier already chosen is written into the new text
     * columns before the old ones go, so nothing entered is lost.
     */
    public function up(): void
    {
        Schema::table('routers', function (Blueprint $table) {
            $table->string('isp_provider')->nullable()->after('model');
            $table->string('account_site')->nullable()->after('status');
        });

        Schema::table('internet_sims', function (Blueprint $table) {
            $table->string('account_site')->nullable()->after('line_active');
        });

        $this->backfillRouters();
        $this->backfillSims();

        Schema::table('routers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('supplier_id');
            $table->dropConstrainedForeignId('employee_id');
            $table->dropConstrainedForeignId('department_id');
            $table->dropConstrainedForeignId('project_id');
            $table->dropConstrainedForeignId('client_employee_id');
            $table->dropConstrainedForeignId('consultant_id');
        });

        Schema::table('internet_sims', function (Blueprint $table) {
            $table->dropConstrainedForeignId('employee_id');
            $table->dropConstrainedForeignId('department_id');
            $table->dropConstrainedForeignId('project_id');
            $table->dropConstrainedForeignId('client_employee_id');
            $table->dropConstrainedForeignId('consultant_id');
        });
    }

    /** Names for whatever each row currently points at. */
    private function siteFor(object $row): ?string
    {
        return match (true) {
            (bool) $row->employee_id => DB::table('employees')->where('id', $row->employee_id)->value('name'),
            (bool) $row->department_id => DB::table('departments')->where('id', $row->department_id)->value('name'),
            (bool) $row->project_id => DB::table('projects')->where('id', $row->project_id)->value('project_name'),
            (bool) $row->client_employee_id => DB::table('client_employees')->where('id', $row->client_employee_id)->value('name'),
            (bool) $row->consultant_id => DB::table('consultants')->where('id', $row->consultant_id)->value('name'),
            default => null,
        };
    }

    private function backfillRouters(): void
    {
        foreach (DB::table('routers')->get() as $row) {
            DB::table('routers')->where('id', $row->id)->update([
                'account_site' => $this->siteFor($row),
                'isp_provider' => $row->supplier_id
                    ? DB::table('suppliers')->where('id', $row->supplier_id)->value('name')
                    : null,
            ]);
        }
    }

    private function backfillSims(): void
    {
        foreach (DB::table('internet_sims')->get() as $row) {
            DB::table('internet_sims')->where('id', $row->id)->update([
                'account_site' => $this->siteFor($row),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('routers', function (Blueprint $table) {
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->foreignId('client_employee_id')->nullable()->constrained('client_employees')->nullOnDelete();
            $table->foreignId('consultant_id')->nullable()->constrained('consultants')->nullOnDelete();
            $table->dropColumn(['isp_provider', 'account_site']);
        });

        Schema::table('internet_sims', function (Blueprint $table) {
            $table->foreignId('employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->foreignId('client_employee_id')->nullable()->constrained('client_employees')->nullOnDelete();
            $table->foreignId('consultant_id')->nullable()->constrained('consultants')->nullOnDelete();
            $table->dropColumn('account_site');
        });
    }
};
