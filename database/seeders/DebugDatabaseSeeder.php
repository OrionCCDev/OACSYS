<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DebugDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info("=== DETAILED DEBUG FOR EMPLOYEE MAPPING ISSUE ===\n");

        // 1. Check if employee 915 exists - CORRECTED
        $this->command->info("1. CHECKING EMPLOYEE WITH EMPLOYEE_ID 915:");

        // Check by employee_id field (the correct field!)
        $employeeBy_employee_id = DB::table('employees')->where('employee_id', 915)->first();
        $employeeBy_employee_id_str = DB::table('employees')->where('employee_id', '915')->first();

        // Check by id field (what the FK references)
        $employeeBy_id = DB::table('employees')->where('id', 915)->first();

        $this->command->line("By employee_id field (915): " . ($employeeBy_employee_id ? "EXISTS" : "NOT FOUND"));
        $this->command->line("By employee_id field ('915'): " . ($employeeBy_employee_id_str ? "EXISTS" : "NOT FOUND"));
        $this->command->line("By id field (915): " . ($employeeBy_id ? "EXISTS" : "NOT FOUND"));

        if ($employeeBy_employee_id) {
            $this->command->info("\n✅ Employee found by employee_id = 915:");
            $this->command->line("  Primary Key (id): " . $employeeBy_employee_id->id);
            $this->command->line("  Employee ID: " . $employeeBy_employee_id->employee_id);
            $this->command->line("  Name: " . ($employeeBy_employee_id->name ?? 'NULL'));
            $this->command->line("  Type: " . $employeeBy_employee_id->type);

            $this->command->info("🔑 SOLUTION: Use primary key {$employeeBy_employee_id->id} for foreign key, not 915!");
        } else {
            $this->command->error("❌ Employee with employee_id = 915 not found");
        }

        // 2. Check employees around employee_id 915
        $this->command->info("\n2. EMPLOYEES AROUND EMPLOYEE_ID 915:");
        $nearby = DB::table('employees')
            ->where('employee_id', '>=', '910')
            ->where('employee_id', '<=', '920')
            ->orderBy('employee_id')
            ->get(['id', 'employee_id', 'name']);

        if ($nearby->count() > 0) {
            foreach ($nearby as $emp) {
                $this->command->line("  Primary Key: {$emp->id} | Employee ID: {$emp->employee_id} | Name: {$emp->name}");
            }
        } else {
            $this->command->line("  No employees found with employee_id between 910-920");
        }

        // 3. Try the correct insert
        $this->command->info("\n3. TESTING CORRECT INSERT:");

        try {
            // Get the correct primary key for employee_id 915
            $employee = DB::table('employees')->where('employee_id', '915')->first();

            if (!$employee) {
                $this->command->error("❌ Employee with employee_id = 915 not found");
            } else {
                $correctPrimaryKey = $employee->id;
                $this->command->info("Found employee: employee_id = 915 has primary key = {$correctPrimaryKey}");

                // Check if device already exists
                $existingDevice = DB::table('devices')->where('employee_id', $correctPrimaryKey)->first();
                if ($existingDevice) {
                    $this->command->info("Device with employee_id {$correctPrimaryKey} already exists:");
                    $this->command->line("  Device: {$existingDevice->device_name} ({$existingDevice->device_code})");
                }

                // Try to insert a test device with the CORRECT primary key
                $testDeviceCode = 'TEST_' . time();

                $this->command->info("Attempting to insert test device with employee_id {$correctPrimaryKey} (employee_id field = 915)...");

                DB::table('devices')->insert([
                    'employee_id' => $correctPrimaryKey, // Use the primary key, not the employee_id field
                    'device_name' => 'Test Device',
                    'device_type' => 'pc',
                    'device_code' => $testDeviceCode,
                    'short_description' => 'Test device for debugging',
                    'main_image' => 'default-device.jpg',
                    'stored_at' => 'office',
                    'health' => 'New',
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->command->info("✅ SUCCESS! Test device inserted successfully with primary key {$correctPrimaryKey}!");

                // Clean up test device
                DB::table('devices')->where('device_code', $testDeviceCode)->delete();
                $this->command->info("Test device cleaned up.");
            }
        } catch (\Exception $e) {
            $this->command->error("❌ FAILED! Error: " . $e->getMessage());
        }

        // 4. Show the field mapping issue
        $this->command->info("\n4. FIELD MAPPING ISSUE EXPLANATION:");
        $this->command->line("❌ Wrong: Your device data has employee_id values (915, 1504, etc.)");
        $this->command->line("❌ Wrong: But FK constraint references employees.id (primary key)");
        $this->command->line("✅ Correct: Need to lookup employees.id WHERE employees.employee_id = '915'");
        $this->command->line("✅ Correct: Then use that id for the foreign key");

        // 5. Show sample mapping
        $this->command->info("\n5. EMPLOYEE ID MAPPING EXAMPLES:");
        $sampleEmployeeIds = ['64', '198', '399', '444', '614', '915', '1504', '2005'];

        foreach ($sampleEmployeeIds as $empId) {
            $employee = DB::table('employees')->where('employee_id', $empId)->first(['id', 'employee_id', 'name']);
            if ($employee) {
                $this->command->line("  employee_id '{$empId}' → primary key {$employee->id} ({$employee->name})");
            } else {
                $this->command->line("  employee_id '{$empId}' → NOT FOUND");
            }
        }

        // 6. Show table structures
        $this->command->info("\n6. TABLE STRUCTURE CONFIRMATION:");

        $employeeColumns = DB::select("DESCRIBE employees");
        $this->command->info("EMPLOYEES table key columns:");
        foreach ($employeeColumns as $column) {
            if (in_array($column->Field, ['id', 'employee_id'])) {
                $this->command->line("  - {$column->Field}: {$column->Type} | Key: {$column->Key} | Null: {$column->Null}");
            }
        }

        $deviceColumns = DB::select("DESCRIBE devices");
        $this->command->info("DEVICES table employee_id column:");
        foreach ($deviceColumns as $column) {
            if ($column->Field === 'employee_id') {
                $this->command->line("  - {$column->Field}: {$column->Type} | Key: {$column->Key} | Null: {$column->Null}");
            }
        }

        // 7. Show foreign key constraint
        $this->command->info("\n7. FOREIGN KEY CONSTRAINT:");
        try {
            $fkInfo = DB::select("
                SELECT
                    kcu.TABLE_NAME,
                    kcu.COLUMN_NAME,
                    kcu.CONSTRAINT_NAME,
                    kcu.REFERENCED_TABLE_NAME,
                    kcu.REFERENCED_COLUMN_NAME
                FROM information_schema.KEY_COLUMN_USAGE kcu
                WHERE kcu.REFERENCED_TABLE_NAME = 'employees'
                AND kcu.TABLE_SCHEMA = DATABASE()
                AND kcu.TABLE_NAME = 'devices'
            ");

            foreach ($fkInfo as $fk) {
                $this->command->line("FK Constraint: {$fk->TABLE_NAME}.{$fk->COLUMN_NAME} → {$fk->REFERENCED_TABLE_NAME}.{$fk->REFERENCED_COLUMN_NAME}");
                $this->command->line("Constraint Name: {$fk->CONSTRAINT_NAME}");
            }
        } catch (\Exception $fkE) {
            $this->command->error("Could not get FK info: " . $fkE->getMessage());
        }

        // 8. Final summary
        $this->command->info("\n" . str_repeat("=", 60));
        $this->command->info("🔍 DIAGNOSIS SUMMARY:");
        $this->command->info("✅ Employee with employee_id '915' " . ($employeeBy_employee_id_str ? "EXISTS" : "DOES NOT EXIST"));
        $this->command->info("❌ Employee with id = 915 " . ($employeeBy_id ? "EXISTS" : "DOES NOT EXIST"));
        $this->command->info("🔑 FK Constraint: devices.employee_id → employees.id");
        $this->command->info("📋 Your Data: Contains employee_id field values, not primary keys");
        $this->command->info("💡 Solution: Map employee_id field values to primary keys before insert");
        $this->command->info(str_repeat("=", 60));

        $this->command->info("\n=== DEBUG COMPLETE ===");
    }
}
