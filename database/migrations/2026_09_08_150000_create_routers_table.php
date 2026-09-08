<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Routers as their own records rather than rows in devices.
     *
     * Existing device_type='Router' devices are deliberately left where they
     * are, as history - same approach taken with printers. New routers are
     * recorded here.
     *
     * Where a router sits is held the same way sim_cards holds it: a nullable
     * FK per kind of holder, at most one set. That keeps a router assignable
     * to an employee, a department, a project, a client or a consultant
     * without inventing a parallel scheme.
     */
    public function up(): void
    {
        Schema::create('routers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->string('main_image')->default('default_device.png');

            // in-stock  = held by IT, not issued
            // active    = issued and in service
            // faulty    = with IT or the supplier for repair
            // retired   = out of service for good
            $table->enum('status', ['in-stock', 'active', 'faulty', 'retired'])->default('in-stock');

            // Who currently holds it. At most one of these is set.
            $table->foreignId('employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->foreignId('client_employee_id')->nullable()->constrained('client_employees')->nullOnDelete();
            $table->foreignId('consultant_id')->nullable()->constrained('consultants')->nullOnDelete();

            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routers');
    }
};
