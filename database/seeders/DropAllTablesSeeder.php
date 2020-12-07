<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropAllTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $collections = DB::connection()->getMongoDB()->listCollections();
        foreach($collections as $collection){
            Schema::drop($collection->getName());
        }
    }
}
