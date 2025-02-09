<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('manager_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->foreignId('position_id')->nullable()->constrained('positions')->nullOnDelete();


        });

        Schema::table('devices', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->constrained('client_employees' , 'id')->nullOnDelete();
            $table->foreignId('consultant_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('receive_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('client_employees', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('consultants', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('project_manager_id')->nullable()->constrained('employees' , 'id')->nullOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients' , 'id')->nullOnDelete();
        });

        Schema::table('sim_cards', function (Blueprint $table) {
            $table->foreignId('client_employee_id')->nullable()->constrained('client_employees')->nullOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('consultant_id')->nullable()->constrained()->nullOnDelete();
        });
        Schema::table('receives', function (Blueprint $table) {
            $table->foreignId('employee_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('client_employee_id')->nullable()->constrained('client_employees' , 'id')->onDelete('cascade');
            $table->foreignId('consultant_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['project_id']);
            $table->dropForeign(['position_id']);
            $table->dropForeign(['sim_id']);
            $table->dropColumn(['sim_id','manager_id', 'department_id', 'project_id','position_id']);
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['consultant_id']);
            $table->dropForeign(['client_id']);
            $table->dropForeign(['employee_id']);
            $table->dropColumn(['project_id','consultant_id' , 'client_id','employee_id']);
        });

        Schema::table('client_employees', function (Blueprint $table) {
            $table->dropForeign(['sim_id']);
            $table->dropForeign(['client_id']);
            $table->dropForeign(['project_id']);
            $table->dropColumn(['project_id','sim_id','client_id']);
        });

        Schema::table('consultants', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['project_manager_id']);
            $table->dropColumn('project_manager_id');
        });
    }
};
