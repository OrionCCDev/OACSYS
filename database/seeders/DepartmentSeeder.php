<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'IT','id'=>1],
            ['name' => 'Accountant','id'=>2],
            ['name' => 'Architecture','id'=>3],
            ['name' => 'civil','id'=>4],
            ['name' => 'Cost Control','id'=>5],
            ['name' => 'Document Controller','id'=>6],
            ['name' => 'Estimation','id'=>7],
            ['name' => 'Human Resources','id'=>8],
            ['name' => 'Labour','id'=>9],
            ['name' => 'Logistics','id'=>10],
            ['name' => 'MEP','id'=>11],
            ['name' => 'Operator','id'=>12],
            ['name' => 'Safety','id'=>13],
            ['name' => 'Stuff','id'=>17],
            ['name' => 'Store','id'=>14],
            ['name' => 'Surveyors','id'=>15],
            ['name' => 'Others','id'=>16],
        ];
        foreach ($data as $key => $value) {
            \App\Models\Department::create([
                'id' => $value['id'],
                'name' => $value['name'],
            ]);
        }
    }
}
