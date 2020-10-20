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
        Administrator::create([
            'first_name' => 'Orbital',
            'last_name' => 'Pereira',
            'email' => 'no-reply@company',
            'password' => 'master',
            'role_id' => Role::where('name', 'Root')->first()->id,
            'active' => true
        ]);
    }
}
