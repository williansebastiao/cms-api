<?php

namespace Database\Seeders;

use App\Models\Administrator;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $users = [
            [
                'first_name' => 'Márcia',
                'last_name' => 'Pereirs',
                'email' => 'marcia@4vconnect.com',
                'avatar' => null,
                'password' => '12345678',
                'role_id' => Role::where('name', 'Root')->first()->id,
                'active' => true
            ],
            [
                'first_name' => 'Patrícia',
                'last_name' => 'Pereira',
                'email' => 'patricia@4vconnect.com',
                'avatar' => null,
                'password' => '12345678',
                'role_id' => Role::where('name', 'Root')->first()->id,
                'active' => true
            ]
        ];
        foreach ($users as $user) {
            Administrator::create($user);
        }
    }
}
