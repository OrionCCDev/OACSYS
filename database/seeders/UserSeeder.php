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
        $u1 = User::create([
            'name' => 'AhmedSayed',
            'email' => 'a.sayed@it.orion',
            'password' => bcrypt('THEgh0$t'),
            'image' => 'sayed.jpg',
            'orion_role_lvl' => 'o-super-admin'
        ]);
        $u2 = User::create([
            'name' => 'AhmedFaisal',
            'email' => 'a.faisal@it.orion',
            'password' => bcrypt('AHMED@ALHAG@128'),
            'image' => 'faisal.jpg',
            'orion_role_lvl' => 'o-super-admin'
        ]);
        $u3 = User::create([
            'name' => 'hr',
            'email' => 'hr@orion.com',
            'password' => bcrypt('hr@123'),
            'image' => 'hr.jpg',
            'orion_role_lvl' => 'o-hr'
        ]);

        $u1->addRole('o-super-admin');
        $u2->addRole('o-super-admin');
        $u3->addRole('o-hr');
    }
}
