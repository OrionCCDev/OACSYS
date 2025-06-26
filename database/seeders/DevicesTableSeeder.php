<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Device; // Adjust the model path as needed

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Device data from the JSON
        $devices = [
            [
                "employee_id" => 64,
                "device_name" => "HP Desktop PC Set",
                "device_type" => "pc",
                "device_code" => "PC2506080000",
                "short_description" => "Desktop PC Set with Core I5, 8GB RAM - includes monitor, keyboard, mouse",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 198,
                "device_name" => "Dell All-in-One PC",
                "device_type" => "pc",
                "device_code" => "PC2506080237",
                "short_description" => "Gray Color All-in-One Computer - 15-34705 CPU, 12.0GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 399,
                "device_name" => "HP All-in-One PC",
                "device_type" => "pc",
                "device_code" => "PC2506080514",
                "short_description" => "Black Color All-in-One Computer - i3-3240 CPU, 4.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 444,
                "device_name" => "HP Desktop PC Set",
                "device_type" => "pc",
                "device_code" => "PC2506080751",
                "short_description" => "Desktop PC Set with monitor and keyboard - i3-8130U CPU, 8.00GB RAM - includes mouse",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 614,
                "device_name" => "HP All-in-One PC",
                "device_type" => "pc",
                "device_code" => "PC2506081028",
                "short_description" => "White Color All-in-One Computer - 13-1200 CPU, 32.0GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 693,
                "device_name" => "HP Envy Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506081305",
                "short_description" => "HP Envy Series - 7-1355U 1, 16.0GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 791,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506081542",
                "short_description" => "15.6\" Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 915,
                "device_name" => "Desktop Computer",
                "device_type" => "pc",
                "device_code" => "PC2506081819",
                "short_description" => "Desktop Computer - i5-4590S CPU, 16.0GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 1504,
                "device_name" => "HP All-in-One PC",
                "device_type" => "pc",
                "device_code" => "PC2506082056",
                "short_description" => "White Color All-in-One Computer - i3-1215U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2005,
                "device_name" => "Desktop PC Set",
                "device_type" => "pc",
                "device_code" => "PC2506082333",
                "short_description" => "Desktop PC Set - i3-1220P CPU, 8.00GB RAM - includes monitor, keyboard, mouse",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2506,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506090210",
                "short_description" => "HP Laptop - i7-1255U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2545,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506090447",
                "short_description" => "HP Laptop - i3-1125G4, 2.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2758,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506090724",
                "short_description" => "15.6\" Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],

            [
                "employee_id" => 2789,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506091238",
                "short_description" => "Navy Blue Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2796,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506091515",
                "short_description" => "Dark Blue Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2801,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506091752",
                "short_description" => "15.6\" Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2823,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506092029",
                "short_description" => "15.6\" Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2840,
                "device_name" => "Lenovo Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506092306",
                "short_description" => "Black Color Lenovo Laptop - i5-1235U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2923,
                "device_name" => "Lenovo Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506092543",
                "short_description" => "Lenovo Laptop - i7-7700HQ CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2937,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506100020",
                "short_description" => "Black Color RTX 4060 Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2954,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506100257",
                "short_description" => "Navy Blue Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2956,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506100534",
                "short_description" => "Silver Color HP Laptop - i7-1255 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 2975,
                "device_name" => "Lenovo Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506100811",
                "short_description" => "Gray Color Lenovo Laptop - i5-1235U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3015,
                "device_name" => "Desktop PC Set",
                "device_type" => "pc",
                "device_code" => "PC2506101048",
                "short_description" => "Desktop PC Set - i5-9400 CPU, 8.00GB RAM - includes monitor, keyboard, mouse",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3017,
                "device_name" => "HP Envy Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506101325",
                "short_description" => "HP Envy Series - 7-1355U 1, 16.0GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3053,
                "device_name" => "Dell Desktop Set",
                "device_type" => "pc",
                "device_code" => "PC2506101602",
                "short_description" => "Dell Computer Set - i3-1220P CPU, 8.00GB RAM - includes monitor, keyboard, mouse",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3058,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506101839",
                "short_description" => "Navy Blue Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3059,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506102116",
                "short_description" => "Silver Color HP Laptop - i5-1235U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3062,
                "device_name" => "HP Desktop PC",
                "device_type" => "pc",
                "device_code" => "PC2506102353",
                "short_description" => "White Color HP PC - i9-1390, 16.0GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3129,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506110030",
                "short_description" => "Blue Color Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3152,
                "device_name" => "Desktop PC Set",
                "device_type" => "pc",
                "device_code" => "PC2506110307",
                "short_description" => "Desktop PC Set - i5-9400 CPU, 8.00GB RAM - includes monitor, keyboard, mouse",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3179,
                "device_name" => "Desktop PC Set",
                "device_type" => "pc",
                "device_code" => "PC2506110544",
                "short_description" => "Desktop PC Set - i5-12400 CPU, 8.00GB RAM - includes keyboard, mouse",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3179,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506110821",
                "short_description" => "Dark Blue Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3180,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506111058",
                "short_description" => "Dark Blue Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3191,
                "device_name" => "Lenovo Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506111335",
                "short_description" => "Gray Color Lenovo Laptop - 5-1155G7 CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],

            [
                "employee_id" => 3203,
                "device_name" => "Desktop PC Set",
                "device_type" => "pc",
                "device_code" => "PC2506111849",
                "short_description" => "Desktop PC Set with 2 monitors - i5-9400 CPU, 8.00GB RAM - includes monitor, keyboard, mouse",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3228,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506112126",
                "short_description" => "Black Color HP Laptop - i5-1235U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3229,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506112403",
                "short_description" => "Black Color HP Laptop - i5-1235 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3230,
                "device_name" => "HP Desktop PC",
                "device_type" => "pc",
                "device_code" => "PC2506120040",
                "short_description" => "Gray Color HP Desktop - i5-9400 CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3232,
                "device_name" => "HP All-in-One PC",
                "device_type" => "pc",
                "device_code" => "PC2506120317",
                "short_description" => "White Color All-in-One Computer - i3-1215U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3234,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506120554",
                "short_description" => "15.6\" Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3249,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506120831",
                "short_description" => "Black Color HP Laptop - i5-1235U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3250,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506121108",
                "short_description" => "Black Color HP Laptop - i5-1235U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3280,
                "device_name" => "MSI Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506121345",
                "short_description" => "Black Color MSI Gaming Laptop - i9-11900H CPU, 16.0GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3283,
                "device_name" => "Acer Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506121622",
                "short_description" => "Black Color Acer Laptop - 17-6500U CPU, 16.0GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3287,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506121859",
                "short_description" => "Black Color HP Laptop - i5-1235U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3289,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506122136",
                "short_description" => "Black Color HP Laptop - i5-1235U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3290,
                "device_name" => "HP All-in-One PC",
                "device_type" => "pc",
                "device_code" => "PC2506122413",
                "short_description" => "White Color All-in-One Computer - i3-1215U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3304,
                "device_name" => "Dell Desktop PC",
                "device_type" => "pc",
                "device_code" => "PC2506130050",
                "short_description" => "Black Color Dell Desktop - i5-1235U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3311,
                "device_name" => "Lenovo Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506130327",
                "short_description" => "Gray Color Lenovo Laptop - 5-1155G7 CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3312,
                "device_name" => "Desktop Computer",
                "device_type" => "pc",
                "device_code" => "PC2506130604",
                "short_description" => "Desktop Computer - i5-1035G1 CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3323,
                "device_name" => "Desktop PC Set",
                "device_type" => "pc",
                "device_code" => "PC2506130841",
                "short_description" => "Desktop PC Set - i5-9400 CPU, 8.00GB RAM - includes monitor, keyboard, mouse",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3328,
                "device_name" => "Lenovo Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506131118",
                "short_description" => "Gray Color Lenovo Laptop - 5-1155G7 CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3332,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506131355",
                "short_description" => "Dark Blue Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3334,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506131632",
                "short_description" => "Black Color HP Laptop - 15-1235U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3338,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506131909",
                "short_description" => "Blue Color Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3343,
                "device_name" => "Acer Desktop PC",
                "device_type" => "pc",
                "device_code" => "PC2506132146",
                "short_description" => "Black Color Acer Desktop - i5-1035G1 CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3346,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506132423",
                "short_description" => "Gray Color HP Laptop - 5-1155G7 CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3348,
                "device_name" => "HP All-in-One PC",
                "device_type" => "pc",
                "device_code" => "PC2506140100",
                "short_description" => "Gray and Black All-in-One Computer - i3-1215U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3368,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506140337",
                "short_description" => "Silver Color HP Laptop - ¡3-10110U CPU, 12.0GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3388,
                "device_name" => "HP All-in-One PC",
                "device_type" => "pc",
                "device_code" => "PC2506140614",
                "short_description" => "White Color All-in-One Computer - i3-1215U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3472,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506140851",
                "short_description" => "15.6\" Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3473,
                "device_name" => "HP Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506141128",
                "short_description" => "Silver Color HP Laptop - i5-1235U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3474,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506141405",
                "short_description" => "15.6\" Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3486,
                "device_name" => "Desktop Computer",
                "device_type" => "pc",
                "device_code" => "PC2506141642",
                "short_description" => "Desktop Computer - i3-10110U CPU, 12.0GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3494,
                "device_name" => "HP All-in-One PC",
                "device_type" => "pc",
                "device_code" => "PC2506141919",
                "short_description" => "Black Color All-in-One Computer - i3-1215U 1, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3513,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506142156",
                "short_description" => "Dark Blue Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ],
            [
                "employee_id" => 3547,
                "device_name" => "HP Victus Gaming Laptop",
                "device_type" => "laptop",
                "device_code" => "LA2506142433",
                "short_description" => "15.6\" Gaming Laptop - i5-12450H CPU, 8.00GB RAM",
                "status" => "taken",
                "health" => "Medium_use"
            ]
        ];

        $this->command->info("Starting corrected device seeding...");
        $this->command->info("Mapping employee_id field values to primary keys...\n");

        // Pre-build employee mapping for efficiency
        $this->command->info("Building employee mapping...");
        $employeeMapping = [];
        $employees = DB::table('employees')->get(['id', 'employee_id']);

        foreach ($employees as $employee) {
            if ($employee->employee_id) {
                $employeeMapping[$employee->employee_id] = $employee->id;
            }
        }

        $this->command->info("Found " . count($employeeMapping) . " employees with employee_id values");

        $addedCount = 0;
        $skippedExistingCount = 0;
        $skippedMissingEmployeeCount = 0;
        $missingEmployeeIds = [];

        foreach ($devices as $deviceData) {
            try {
                $employeeIdValue = $deviceData['employee_id'];

                // Check if device already exists
                if (DB::table('devices')->where('device_code', $deviceData['device_code'])->exists()) {
                    $this->command->info("Device {$deviceData['device_code']} already exists - skipping");
                    $skippedExistingCount++;
                    continue;
                }

                // Map employee_id value to primary key
                if (!isset($employeeMapping[$employeeIdValue])) {
                    $this->command->warn("Employee with employee_id '{$employeeIdValue}' not found - skipping device {$deviceData['device_code']}");
                    $missingEmployeeIds[] = $employeeIdValue;
                    $skippedMissingEmployeeCount++;
                    continue;
                }

                $primaryKey = $employeeMapping[$employeeIdValue];

                // Insert device with correct primary key
                DB::table('devices')->insert([
                    'employee_id' => $primaryKey, // Use primary key, not employee_id field value
                    'device_name' => $deviceData['device_name'],
                    'device_type' => $deviceData['device_type'],
                    'device_code' => $deviceData['device_code'],
                    'short_description' => $deviceData['short_description'],
                    'status' => $deviceData['status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->command->info("✓ Added device {$deviceData['device_code']} for employee_id '{$employeeIdValue}' (primary key: {$primaryKey})");
                $addedCount++;

            } catch (\Exception $e) {
                $this->command->error("Error processing device {$deviceData['device_code']}: " . $e->getMessage());
            }
        }

        // Summary
        $this->command->info("\n" . str_repeat("=", 60));
        $this->command->info("CORRECTED SEEDING COMPLETED!");
        $this->command->info(str_repeat("=", 60));
        $this->command->info("✅ Added: {$addedCount} devices");
        $this->command->info("⏭️ Skipped (already exist): {$skippedExistingCount} devices");
        $this->command->info("⚠️ Skipped (missing employee): {$skippedMissingEmployeeCount} devices");

        if (!empty($missingEmployeeIds)) {
            $this->command->warn("\nMissing Employee IDs (" . count($missingEmployeeIds) . "):");
            $this->command->line(implode(', ', array_unique($missingEmployeeIds)));
        }

        $this->command->info("\n💡 KEY INSIGHT:");
        $this->command->info("Your device data contains employee_id FIELD values, not primary keys.");
        $this->command->info("This seeder now correctly maps them to the actual primary keys.");
    }
}

// Quick verification seeder
class VerifyEmployeeMappingSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info("=== EMPLOYEE MAPPING VERIFICATION ===");

        // Sample employee_id values from your device data
        $sampleEmployeeIds = ['64', '198', '399', '444', '614', '693', '791', '915', '1504', '2005', '2506', '2545'];

        $this->command->info("Checking mapping for sample employee_id values:\n");

        foreach ($sampleEmployeeIds as $empId) {
            $employee = DB::table('employees')->where('employee_id', $empId)->first(['id', 'employee_id', 'name']);

            if ($employee) {
                $this->command->line("✅ employee_id '{$empId}' → primary key {$employee->id} | {$employee->name}");
            } else {
                $this->command->line("❌ employee_id '{$empId}' → NOT FOUND");
            }
        }

        $this->command->info("\n=== VERIFICATION COMPLETE ===");
    }
}