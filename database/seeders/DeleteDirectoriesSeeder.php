<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DeleteDirectoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $directories = Storage::disk('public')->directories();
        foreach ($directories as $director){
            Storage::deleteDirectory($director);
        }
    }
}
