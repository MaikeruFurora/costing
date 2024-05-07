<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostingHeader extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public static function setPrefixSeries($type,$isarray=false,$count=0){

        $res = Static::orderBy('id', 'DESC')->whereDate('created_at',Carbon::now())->first();

        if (!is_null($res)) {
            $iterate = ($res->id+1);
        }else{
            $iterate = 1;
        }

        if ($isarray) {
            $series = [];
            foreach(range(1, $count) as $i){
                $series[] = strtoupper($type).date("yn").sprintf('%03s', $iterate + $i - 1);
            }
            return $series;
        }

        $series = strtoupper($type).date("yn").sprintf('%03s', $iterate);

        return $series;

    }

    public function costing(){
        return $this->hasMany(Costing::class);
    }

    public function warehouseOrigin(){
        return $this->belongsTo(WarehouseOrigin::class);
    }

    public function trucktype(){
        return $this->belongsTo(Trucktype::class);
    }
}
