<?php

namespace Database\Seeders;

use App\Models\WarehouseOrigin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WarehouseOriginTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // delete records from the table
        DB::table('warehouse_origin')->delete();
        
        WarehouseOrigin::insert([
            [
                'warehouse' => 'Bataan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'warehouse' => 'Calaca',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'warehouse' => 'Harbour',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'warehouse' => 'Malabon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'warehouse' => 'Pampanga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'warehouse' => 'PNOC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'warehouse' => 'Subic',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
 