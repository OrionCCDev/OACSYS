<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A receive or clearance is normally closed by uploading the signed paper.
 * When there is no paper to upload it can be closed anyway, and these
 * columns record that it was, by whom, when and why - so a closed record
 * with no document is an explained exception rather than a gap.
 */
return new class extends Migration
{
    private array $tables = ['receives', 'clearances'];

    public function up(): void
    {
        foreach ($this->tables as $name) {
            Schema::table($name, function (Blueprint $table) use ($name) {
                if (!Schema::hasColumn($name, 'force_closed_at')) {
                    $table->timestamp('force_closed_at')->nullable();
                }
                if (!Schema::hasColumn($name, 'force_closed_by')) {
                    $table->foreignId('force_closed_by')->nullable()->constrained('users')->nullOnDelete();
                }
                if (!Schema::hasColumn($name, 'force_close_reason')) {
                    $table->string('force_close_reason', 500)->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $name) {
            Schema::table($name, function (Blueprint $table) use ($name) {
                if (Schema::hasColumn($name, 'force_closed_by')) {
                    $table->dropConstrainedForeignId('force_closed_by');
                }
                foreach (['force_closed_at', 'force_close_reason'] as $column) {
                    if (Schema::hasColumn($name, $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
