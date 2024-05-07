<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupAreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_areas')->delete();
        DB::table('group_areas')->insert([ 
            [
                'area'       => 'North Luzon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area' => 'Calabarzon Area',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area' => 'Manila Area',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area' => 'South Luzon Area',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
