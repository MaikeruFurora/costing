<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseOrigin extends Model
{
    use HasFactory;
    protected $table = 'warehouse_origin';
    protected $guarded = [];


    public function costingHeader(){
        return $this->hasMany(CostingHeader::class);
    }

    public function priceIndex(){
        return $this->hasMany(PriceIndex::class);
    }

}
