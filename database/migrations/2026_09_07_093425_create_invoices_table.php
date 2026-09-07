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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('printer_id')->constrained('printers')->onDelete('cascade');
            $table->string('num');
            $table->date('released_date');
            // Billing period this invoice covers - normally a full quarter, but
            // the last invoice for a printer can be shorter if its project ends
            // (and the printer transfers or is cancelled) before 3 months are up.
            $table->date('start_date');
            $table->date('end_date');
            $table->string('payment_term')->nullable();
            $table->string('invoice_document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
