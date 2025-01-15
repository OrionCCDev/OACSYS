<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'AhmedSayed',
            'email' => 'a.sayed@it.orion',
            'password' => bcrypt('THEgh0$t'),
            'image' => 'sayed.jpg',
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'AhmedFaisal',
            'email' => 'a.faisal@it.orion',
            'password' => bcrypt('AHMED@ALHAG@128'),
            'image' => 'faisal.jpg',
            'role' => 'admin'
        ]);
    }
}
