<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $u1 = User::create([
        //     'name' => 'AhmedSayed',
        //     'email' => 'a.sayed@it.orion',
        //     'password' => bcrypt('THEgh0$t'),
        //     'image' => 'sayed.jpg',
        //     'orion_role_lvl' => 'o-super-admin'
        // ]);
        // $u2 = User::create([
        //     'name' => 'AhmedFaisal',
        //     'email' => 'a.faisal@it.orion',
        //     'password' => bcrypt('AHMED@ALHAG@128'),
        //     'image' => 'faisal.jpg',
        //     'orion_role_lvl' => 'o-super-admin'
        // ]);
        // $u3 = User::create([
        //     'name' => 'hr',
        //     'email' => 'hr@orioncc.com',
        //     'password' => bcrypt('hr@123'),
        //     'image' => 'hr.jpg',
        //     'orion_role_lvl' => 'o-hr'
        // ]);

        // $u1->addRole('o-super-admin');
        // $u2->addRole('o-super-admin');
        // $u3->addRole('o-hr');
         // Create users for managers
         $managers = Employee::where('type', 'manager')->get();
         foreach($managers as $manager) {
            $formattedName = strtolower(str_replace(' ', '_', $manager->name));
             $user = User::create([
                 'name' => $manager->name,
                 'email' => $manager->email ?? $formattedName . '@orioncc.com',
                 'password' => bcrypt($formattedName . '@123'), // You can set a default password
                 'image' => $manager->profile_image,
                 'orion_role_lvl' => 'o-manager'
             ]);

             $user->addRole('o-manager');
         }
    }
}
