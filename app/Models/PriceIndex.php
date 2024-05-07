<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceIndex extends Model
{
    use HasFactory;
    protected $table = 'price_index';
    protected $guarded = [];

    public function warehouse_origin(){
        return $this->belongsTo(WarehouseOrigin::class);
    }
}
