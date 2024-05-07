<?php

namespace Database\Seeders;

use App\Models\truckrate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TruckratesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('truckrate')->delete();
        Truckrate::insert([
           [
                'warehouse_origin_id'=> 'CALACA',
                'trucktype_id'       => '10 WHEELER',
                'group_area_id'      => NULL,
                'province'           => 'BATANGAS',
                'municipality'       => 'BALAYAN',
                'rate'               => 15,
                'active'             => 'Y',
                'created_at'         => now(),
                'updated_at'         => now(),
           ],
           [
                'warehouse_origin_id'=> 'CALACA',
                'trucktype_id'       => '10 WHEELER',
                'group_area_id'      => NULL,
                'province'           => 'BATANGAS',
                'municipality'       => 'NASUGBO',
                'rate'               => 15,
                'active'             => 'Y',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
    }
}
