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
            'first_name' => 'Willians',
            'last_name' => 'Pereira',
            'email' => 'willians@4vconnect.com',
            'password' => 'master',
            'role_id' => Role::where('name', 'Root')->first()->id,
            'active' => true
        ]);
    }
}
