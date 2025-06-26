<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DevicesTableSeeder::class);
        // User::factory(10)->create();
        // $this->call(LaratrustSeeder::class);
        // $this->call(DepartmentSeeder::class);
        // $this->call(PositionSeeder::class);
        // $this->call(ClientSeeder::class);
        // $this->call(UserSeeder::class);
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
