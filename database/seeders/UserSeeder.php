<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = Employee::where('id', 132)->first();

        if (! $manager) {
            $this->command->warn('Employee #132 not found; skipping manager user creation.');
            return;
        }

        $password = Str::password(16);

        $user = User::create([
            'name' => 'AHMED ABDELKADER',
            'email' => 'ahmed@orioncc.com',
            'password' => bcrypt($password),
            'image' => $manager->profile_image,
            'orion_role_lvl' => 'o-manager',
            'employee_profile_id' => $manager->id,
        ]);
        $user->addRole($user['orion_role_lvl']);

        $this->command->info("Created user {$user->email} with a generated password: {$password}");
        $this->command->warn('Record this password now - it is not stored anywhere and will not be shown again.');
    }
}
