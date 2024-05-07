<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceIndexLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function warehouse_origin(){
        return $this->belongsTo(WarehouseOrigin::class);
    }
}
