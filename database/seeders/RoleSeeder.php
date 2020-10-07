<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $items = ['Root', 'Administrator', 'User'];
        foreach ($items as $item) {
            Role::create(['name' => $item, 'active' => true]);
        }
    }
}
