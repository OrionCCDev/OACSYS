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
    protected $initialUsers = [
        [
            'id' => 'AhmedSayed',
            'email' => 'a.sayed@it.orion',
            'password' => 'THEgh0$t',
            'image' => 'sayed.jpg',
            'orion_role_lvl' => 'o-super-admin',
            'employee_id' => 3358
        ],
        [
            'name' => 'AhmedFaisal',
            'email' => 'a.faisal@it.orion',
            'password' => 'AHMED@ALHAG@128',
            'image' => 'faisal.jpg',
            'orion_role_lvl' => 'o-super-admin',
            'employee_id' => 3170
        ],
        [
            'name' => 'hr',
            'email' => 'hr@orioncc.com',
            'password' => 'hr@123',
            'image' => 'hr.jpg',
            'orion_role_lvl' => 'o-hr',
            'employee_id' => 614
        ],
    ];
    public function run(): void
    {
        $managers = Employee::where('type', 'manager')->get();
        foreach ($managers as $manager) {
            $user = User::create([
                'name' => $manager->name,
                'email' => $manager->orion_email ?? 'manager@orion.com',
                'password' => bcrypt('manager@' . $manager->id),
                'image' => $manager->profile_image,
                'orion_role_lvl' => 'o-manager',
                'employee_profile_id' => $manager->id
            ]);
        }
            foreach ($this->initialUsers as $userData) {
            $user =  User::updateOrCreate(
                ['email' => $userData['email']], // Find by email
                [
                    'name' => $userData['name'],
                    'password' => bcrypt($userData['password']),
                    'image' => $userData['image'],
                    'orion_role_lvl' => $userData['orion_role_lvl'],
                    'employee_profile_id' => Employee::where('employee_id','=',$userData['employee_id'])->value('id') ?? null
                ]
            );
            $user->addRole($userData['orion_role_lvl']);
        }

        // // Uncomment to automatically create users for all managers
        // $this->createManagerUsers();
        // $u1 = User::create([
        //     'name' => 'AhmedSayed',
        //     'email' => 'a.sayed@it.orion',
        //     'password' => bcrypt('THEgh0$t'),
        //     'image' => 'sayed.jpg',
        //     'orion_role_lvl' => 'o-super-admin',
        //     'employee_profile_id' => 355 ?? null
        // ]);
        // $u2 = User::create([
        //     'name' => 'AhmedFaisal',
        //     'email' => 'a.faisal@it.orion',
        //     'password' => bcrypt('AHMED@ALHAG@128'),
        //     'image' => 'faisal.jpg',
        //     'orion_role_lvl' => 'o-super-admin',
        //     'employee_profile_id' => 354 ?? null

        // ]);
        // $u3 = User::create([
        //     'name' => 'hr',
        //     'email' => 'hr@orioncc.com',
        //     'password' => bcrypt('hr@123'),
        //     'image' => 'hr.jpg',
        //     'orion_role_lvl' => 'o-hr',
        //     'employee_profile_id' => 357 ?? null
        // ]);

        // $u1->addRole('o-super-admin');
        // $u2->addRole('o-super-admin');
        // $u3->addRole('o-hr');
         // Create users for managers
        //  $managers = Employee::where('type', 'manager')->get();
        //  foreach($managers as $manager) {
        //     $formattedName = strtolower(str_replace(' ', '_', $manager->name));
        //      $user = User::create([
        //          'name' => $manager->name,
        //          'email' => $manager->email ?? $formattedName . '@orioncc.com',
        //          'password' => bcrypt($formattedName . '@123'), // You can set a default password
        //          'image' => $manager->profile_image,
        //          'orion_role_lvl' => 'o-manager'
        //      ]);

        //      $user->addRole('o-manager');
        //  }
    }
}
