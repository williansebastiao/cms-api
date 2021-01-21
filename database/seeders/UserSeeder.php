<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $users = [
            [
                'first_name' => 'Márcia',
                'last_name' => 'Pereira',
                'email' => 'marcia@4vconnect.com',
                'avatar' => null,
                'password' => '12345678',
                'role_id' => Role::where('name', 'Root')->first()->id,
                'permission_id' => Permission::where('name', 'Administrator')->first()->id,
                'active' => true
            ],
            [
                'first_name' => 'Patrícia',
                'last_name' => 'Pereira',
                'email' => 'patricia@4vconnect.com',
                'avatar' => null,
                'password' => '12345678',
                'role_id' => Role::where('name', 'Root')->first()->id,
                'permission_id' => Permission::where('name', 'Administrator')->first()->id,
                'active' => true
            ]
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
