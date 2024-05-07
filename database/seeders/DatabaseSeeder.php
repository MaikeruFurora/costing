<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        // Run the UserSeeder class
        // $this->call(TruckratesTableSeeder::class);
        $this->call(WarehouseOriginTableSeeder::class);
        $this->call(TruckTypeTableSeeder::class);
        $this->call(GroupAreaTableSeeder::class);
    }
}
