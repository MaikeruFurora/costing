<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costing extends Model
{
    use HasFactory;
    protected $table = 'costing';
    protected $guarded = [];

    public function costingHeader(){
        return $this->belongsTo(CostingHeader::class);
    }

    public static function setPrefixSeries($type,$isarray=false,$count=0){

         $res = Static::orderBy('id', 'DESC')->whereDate('created_at',Carbon::now())->first();

        if (!is_null($res)) {
             $iterate = (strtotime(date("Ymd",strtotime($res->created_at)))==strtotime(date("Ymd"))) ? ($res->id+1) : 1;
        }else{
            $iterate = 1;
        }

        if ($isarray) {
            $series = [];
            for ($i=1; $i <=$count ; $i++) { 
                ;
                $series[] = strtoupper($type).date("yn").sprintf('%03s', $iterate+$i);
            }
            return $series;
        }else{
            
            $series = strtoupper($type).date("yn").sprintf('%03s', $iterate);

            return $series;
        }

      

    }


    public function scopeStoreCosting($query, $data)
    {
        return $query->create($this->requestData($data));
    }

    public static function cleanNumberByFormat($value){

        $data =  floatval(preg_replace('/[^\d.]/', '', $value));

        return $data;

    }

    public function requestData($data)
    {
        return[
            'user_id'       => auth()->id(),
            'costingNo'     => $data->input('costingNo'),
            'warehouse_origin_id' => $data->input('warehouse_origin_id'),
            'trucktype_id'  => $data->input('trucktype_id'),
            'client'        => $data->input('client'),
            'brand'         => $data->input('brand'),
            'item'          => $data->input('item'),
            'cardCode'      => $data->input('cardCode'),
            'itemCode'      => $data->input('itemCode'),
            'paymentMode'   => $data->input('paymentMode'),
            'taxCode'       => $data->input('taxCode'),
            'province'      => $data->input('province'),
            'municipality'  => $data->input('municipality'),
            'specialPrice'  => $data->input('specialPrice'),
            'form'          => $data->input('form'),
            'truckCategory' => $data->input('truckCategory'),
            'truckerType'   => $data->input('truckerType'),
            'deliveryType'  => $data->input('deliveryType'),
            'confirmation'  => $data->input('confirmation'),
            
            'others'        => $this->cleanNumberByFormat($data->input('others')),
            'quantity'      => $this->cleanNumberByFormat($data->input('quantity')),
            'pickupprice'   => $this->cleanNumberByFormat($data->input('pickupprice')),
            'analysisFee'   => $this->cleanNumberByFormat($data->input('analysisFee')),
            'plasticLiner'  => $this->cleanNumberByFormat($data->input('plasticLiner')),
            'twoDrops'      => $this->cleanNumberByFormat($data->input('twoDrops')),
            'parking'       => $this->cleanNumberByFormat($data->input('parking')),
            'trucking'      => $this->cleanNumberByFormat($data->input('trucking')),
            'additionalTrucking' => $this->cleanNumberByFormat($data->input('additionalTrucking')),
            'tollFee'       => $this->cleanNumberByFormat($data->input('tollFee')),
            'allowance'     => $this->cleanNumberByFormat($data->input('allowance')),
            'loading'       => $this->cleanNumberByFormat($data->input('loading')),
            'unloading'     => $this->cleanNumberByFormat($data->input('unloading')),
            'additionalUnloading' => $this->cleanNumberByFormat($data->input('additionalUnloading')),
            'terms'         => $this->cleanNumberByFormat($data->input('terms')),
            'cleaning'      => $this->cleanNumberByFormat($data->input('cleaning')),
            'entryFee'      => $this->cleanNumberByFormat($data->input('entryFee')),
            'emptySack'     => $this->cleanNumberByFormat($data->input('emptySack')),
            'sticker'       => $this->cleanNumberByFormat($data->input('sticker')),
            'escort'        => $this->cleanNumberByFormat($data->input('escort')),
            'bankCharge'    => $this->cleanNumberByFormat($data->input('bankCharge')),
            'commision'     => $this->cleanNumberByFormat($data->input('commision')),
            'serviceFee'    => $this->cleanNumberByFormat($data->input('serviceFee')),
            'allowanceWeight' => $this->cleanNumberByFormat($data->input('allowanceWeight')),
            'truckScale'    => $this->cleanNumberByFormat($data->input('truckScale')),
            'grossprice'    => $this->cleanNumberByFormat($data->input('grossprice')),
            'rate'          => $this->cleanNumberByFormat($data->input('rate')),
            'sku'           => $this->cleanNumberByFormat($data->input('sku')),
        ];
    }
}
