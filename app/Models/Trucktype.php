<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trucktype extends Model
{
    use HasFactory;
    protected $table = 'trucktype';
    protected $guarded = [];

    public function costingHeader(){
        return $this->hasMany(CostingHeader::class);
    }
}
