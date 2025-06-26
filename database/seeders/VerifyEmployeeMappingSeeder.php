<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VerifyEmployeeMappingSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info("=== EMPLOYEE MAPPING VERIFICATION ===");

        // All employee_id values from your device data
        $deviceEmployeeIds = [
            '64', '198', '399', '444', '614', '693', '791', '915', '1504', '2005',
            '2506', '2545', '2758', '2778', '2789', '2796', '2801', '2823', '2840',
            '2923', '2937', '2954', '2956', '2975', '3015', '3017', '3053', '3058',
            '3059', '3062', '3129', '3152', '3179', '3180', '3191', '3192', '3203',
            '3228', '3229', '3230', '3232', '3234', '3249', '3250', '3280', '3283',
            '3287', '3289', '3290', '3304', '3311', '3312', '3323', '3328', '3332',
            '3334', '3338', '3343', '3346', '3348', '3368', '3388', '3472', '3473',
            '3474', '3486', '3494', '3513', '3547'
        ];

        $this->command->info("Checking mapping for ALL employee_id values from your device data:\n");

        $foundCount = 0;
        $missingCount = 0;
        $missingIds = [];

        foreach ($deviceEmployeeIds as $empId) {
            $employee = DB::table('employees')
                ->where('employee_id', $empId)
                ->first(['id', 'employee_id', 'name']);

            if ($employee) {
                $this->command->line("✅ employee_id '{$empId}' → primary key {$employee->id} | {$employee->name}");
                $foundCount++;
            } else {
                $this->command->line("❌ employee_id '{$empId}' → NOT FOUND");
                $missingIds[] = $empId;
                $missingCount++;
            }
        }

        // Summary
        $this->command->info("\n" . str_repeat("=", 50));
        $this->command->info("MAPPING SUMMARY:");
        $this->command->info("✅ Found: {$foundCount} employees");
        $this->command->info("❌ Missing: {$missingCount} employees");
        $this->command->info("📊 Success Rate: " . round(($foundCount / count($deviceEmployeeIds)) * 100, 1) . "%");

        if (!empty($missingIds)) {
            $this->command->warn("\nMissing employee_id values:");
            $this->command->line(implode(', ', $missingIds));
        }

        // Show database info
        $this->command->info("\nDATABASE INFO:");
        $totalEmployees = DB::table('employees')->count();
        $employeesWithEmployeeId = DB::table('employees')->whereNotNull('employee_id')->count();
        $this->command->line("Total employees in database: {$totalEmployees}");
        $this->command->line("Employees with employee_id field: {$employeesWithEmployeeId}");

        // Show sample of actual employee_id values in database
        $this->command->info("\nSample employee_id values in database:");
        $sampleEmployees = DB::table('employees')
            ->whereNotNull('employee_id')
            ->orderBy('id')
            ->limit(10)
            ->get(['id', 'employee_id', 'name']);

        foreach ($sampleEmployees as $emp) {
            $this->command->line("  Primary Key: {$emp->id} | employee_id: '{$emp->employee_id}' | {$emp->name}");
        }

        $this->command->info("\n=== VERIFICATION COMPLETE ===");

        if ($foundCount > $missingCount) {
            $this->command->info("🎉 GOOD NEWS: Most employees found! You can proceed with corrected seeder.");
        } else {
            $this->command->warn("⚠️ WARNING: Many employees missing. Check your employee_id values.");
        }
    }
}