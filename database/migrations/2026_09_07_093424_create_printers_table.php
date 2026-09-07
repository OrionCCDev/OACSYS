<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();

            // The PO is issued in the ERP, not by this system - the number and
            // document are just recorded here for reference.
            $table->string('po_number');
            $table->string('po_document')->nullable();

            $table->string('name');
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('main_image')->default('default_device.png');

            // Where the printer physically sits within this project engagement.
            $table->enum('delivered_to_type', ['client', 'consultant', 'office']);
            $table->foreignId('client_employee_id')->nullable()->constrained('client_employees')->nullOnDelete();
            $table->foreignId('consultant_id')->nullable()->constrained('consultants')->nullOnDelete();

            // active = in service on this project. transferred = its rental moved
            // on to a new project (see the new row via transferred_from_id).
            // cancelled = rental ended, returned to the supplier.
            $table->enum('status', ['active', 'transferred', 'cancelled'])->default('active');
            $table->date('start_date');
            $table->date('end_date')->nullable();

            // Self-reference so a printer moved between projects can be traced
            // back through its full chain of prior project engagements.
            $table->foreignId('transferred_from_id')->nullable()->constrained('printers')->nullOnDelete();

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
