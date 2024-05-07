<?php

namespace Database\Seeders;

use App\Models\Trucktype;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TruckTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trucktype')->delete();
        
        Trucktype::insert([
            [
                'trucktype' => '10 Wheeler',
                'capacity'  => '25000',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'trucktype' => 'Trailer',
                'capacity'  => '50000',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'trucktype' => 'Forward',
                'capacity'  => '15000',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'trucktype' => 'Elf',
                'capacity'  => '5000',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'trucktype' => 'Hopper',
                'capacity'  => '100000',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'trucktype' => 'PUP',
                'capacity'  => '0',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
