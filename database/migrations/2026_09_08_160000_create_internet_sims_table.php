<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Site internet SIMs, recorded separately from the sim_cards module.
     *
     * They answer a different question. sim_cards tracks SIMs as IT assets -
     * issued to a person, cleared, received, returned. These are the internet
     * lines standing behind site routers and cameras: who the account is
     * registered to with the provider, the contract, whether the line is live,
     * and which router it sits in. Keeping them apart means neither list is
     * cluttered with the other's rows, and the asset workflow (clearances,
     * receives) does not have to make sense for a camera's data line.
     *
     * Where the line ended up is held the way routers hold it: a nullable FK
     * per kind of holder, at most one set. It is recorded here rather than
     * read off the router, because plenty of lines have no router at all.
     */
    public function up(): void
    {
        Schema::create('internet_sims', function (Blueprint $table) {
            $table->id();

            $table->string('sim_number');
            $table->string('sim_provider');
            $table->string('account_name')->nullable();
            $table->string('sim_serial')->nullable();
            $table->string('contract_no')->nullable();

            // Live with the provider. Separate from any assignment: a line can
            // be sitting in stock and live, or issued and suspended.
            $table->boolean('line_active')->default(true);

            $table->foreignId('router_id')->nullable()->constrained('routers')->nullOnDelete();

            // "Account Site" on the report - who the line was delivered to.
            $table->foreignId('employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->foreignId('client_employee_id')->nullable()->constrained('client_employees')->nullOnDelete();
            $table->foreignId('consultant_id')->nullable()->constrained('consultants')->nullOnDelete();

            $table->string('remark')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internet_sims');
    }
};
