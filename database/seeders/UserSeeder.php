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
                'first_name' => 'Wallace',
                'last_name' => 'Erick',
                'email' => 'wallace.erick@orbital.company',
                'avatar' => null,
                'password' => 'orbital@wallace',
                'role_id' => Role::where('name', 'Root')->first()->id,
                'permission_id' => Permission::where('name', 'Administrator')->first()->id,
                'active' => true
            ],
            [
                'first_name' => 'Vinicius',
                'last_name' => 'Luiz',
                'email' => 'vinicius.luiz@orbital.company',
                'avatar' => null,
                'password' => 'orbital@vinicius',
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
