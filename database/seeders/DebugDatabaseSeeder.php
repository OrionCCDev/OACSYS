<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DebugDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info("=== DEBUGGING DATABASE STRUCTURE ===");

        // Check employees table structure
        $this->command->info("\n1. EMPLOYEES TABLE STRUCTURE:");
        $employeeColumns = DB::select("DESCRIBE employees");
        foreach ($employeeColumns as $column) {
            $this->command->line("  - {$column->Field}: {$column->Type} | Null: {$column->Null} | Key: {$column->Key}");
        }

        // Check devices table structure
        $this->command->info("\n2. DEVICES TABLE STRUCTURE:");
        $deviceColumns = DB::select("DESCRIBE devices");
        foreach ($deviceColumns as $column) {
            $this->command->line("  - {$column->Field}: {$column->Type} | Null: {$column->Null} | Key: {$column->Key}");
        }

        // Check foreign key constraints
        $this->command->info("\n3. FOREIGN KEY CONSTRAINTS:");
        $constraints = DB::select("
            SELECT
                CONSTRAINT_NAME,
                COLUMN_NAME,
                REFERENCED_TABLE_NAME,
                REFERENCED_COLUMN_NAME,
                DELETE_RULE,
                UPDATE_RULE
            FROM information_schema.REFERENTIAL_CONSTRAINTS rc
            JOIN information_schema.KEY_COLUMN_USAGE kcu
            ON rc.CONSTRAINT_NAME = kcu.CONSTRAINT_NAME
            WHERE kcu.TABLE_SCHEMA = DATABASE()
            AND kcu.TABLE_NAME = 'devices'
        ");

        foreach ($constraints as $constraint) {
            $this->command->line("  - {$constraint->CONSTRAINT_NAME}: devices.{$constraint->COLUMN_NAME} -> {$constraint->REFERENCED_TABLE_NAME}.{$constraint->REFERENCED_COLUMN_NAME}");
            $this->command->line("    Delete: {$constraint->DELETE_RULE} | Update: {$constraint->UPDATE_RULE}");
        }

        // Check specific employee IDs that worked vs failed
        $this->command->info("\n4. CHECKING SPECIFIC EMPLOYEES:");

        $workedIds = [64, 198, 399, 444, 614, 693, 791];
        $failedIds = [915, 1504, 2005, 2506, 2545];

        $this->command->info("Employees that WORKED:");
        foreach ($workedIds as $id) {
            $employee = DB::table('employees')->where('employee_id', $id)->first();
            if ($employee) {
                $this->command->line("  ✓ ID {$id}: exists (id type: " . gettype($employee->employee_id) . ")");
            } else {
                $this->command->line("  ✗ ID {$id}: NOT FOUND");
            }
        }

        $this->command->info("\nEmployees that FAILED:");
        foreach ($failedIds as $id) {
            $employee = DB::table('employees')->where('employee_id', $id)->first();
            if ($employee) {
                $this->command->line("  ? ID {$id}: exists (id type: " . gettype($employee->employee_id) . ") - but FK failed");

                // Check if there are any special characters or issues
                $this->command->line("    Raw ID value: " . var_export($employee->id, true));
            } else {
                $this->command->line("  ✗ ID {$id}: NOT FOUND");
            }
        }

        // Check for soft deletes
        $this->command->info("\n5. CHECKING FOR SOFT DELETES:");
        $hasDeletedAt = collect($employeeColumns)->firstWhere('Field', 'deleted_at');
        if ($hasDeletedAt) {
            $this->command->line("  - Employees table has 'deleted_at' column (soft deletes enabled)");

            $softDeletedCount = DB::table('employees')->whereNotNull('deleted_at')->count();
            $this->command->line("  - Soft deleted employees: {$softDeletedCount}");

            // Check if failed IDs are soft deleted
            foreach ($failedIds as $id) {
                $softDeleted = DB::table('employees')
                    ->where('employee_id', $id)
                    ->whereNotNull('deleted_at')
                    ->first();
                if ($softDeleted) {
                    $this->command->line("  - ID {$id} is SOFT DELETED!");
                }
            }
        } else {
            $this->command->line("  - No soft deletes detected");
        }

        // Check data types match
        $this->command->info("\n6. DATA TYPE COMPARISON:");
        $employeeIdColumn = collect($employeeColumns)->firstWhere('Field', 'id');
        $deviceEmployeeIdColumn = collect($deviceColumns)->firstWhere('Field', 'employee_id');

        $this->command->line("  - employees.id: {$employeeIdColumn->Type}");
        $this->command->line("  - devices.employee_id: {$deviceEmployeeIdColumn->Type}");

        if ($employeeIdColumn->Type !== $deviceEmployeeIdColumn->Type) {
            $this->command->error("  ⚠️  DATA TYPE MISMATCH DETECTED!");
        } else {
            $this->command->line("  ✓ Data types match");
        }

        // Count total employees
        $this->command->info("\n7. EMPLOYEE COUNTS:");
        $totalEmployees = DB::table('employees')->count();
        $activeEmployees = $hasDeletedAt ?
            DB::table('employees')->whereNull('deleted_at')->count() :
            $totalEmployees;

        $this->command->line("  - Total employees: {$totalEmployees}");
        if ($hasDeletedAt) {
            $this->command->line("  - Active employees: {$activeEmployees}");
        }

        $this->command->info("\n=== DEBUG COMPLETE ===");
    }
}