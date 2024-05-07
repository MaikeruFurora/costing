<?php

namespace App\Services;

use App\Helper\Helper;
use App\Models\PriceIndex;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CostingService{
    
    public function getPrice($itemCode, $warehouseId, $brand, $taxCode, $company, $volume){
        $query = PriceIndex::where('itemCode', $itemCode);

            // check if item and warehouse exists in the query
        if (PriceIndex::where('itemCode', $itemCode)->where('warehouse_origin_id', $warehouseId)->exists() && $company!=='RH') {

            $query->where('warehouse_origin_id', $warehouseId);

            // check item, brand and warehouse exists
            if (PriceIndex::where('itemCode', $itemCode)->where('brand', $brand)->where('warehouse_origin_id', $warehouseId)->exists()) {
                       $query->where('brand', $brand);
                $data = $this->isVolume($query, $volume);
                // echo "check item, brand and warehouse exists";
            } else {
                    // check item, brand and warehouse and company exists
                    if (PriceIndex::where('itemCode', $itemCode)->where('brand', $brand)->where('warehouse_origin_id', $warehouseId)->where('company', $company)->exists()) {    
                                $query->where('company', $company);
                       $data  = $this->isVolume($query, $volume);
                    //    echo "check item, brand and warehouse and company exists";
                    }else{
                    
                        // check item and warehouse
                        if (PriceIndex::where('itemCode', $itemCode)->where('warehouse_origin_id',$warehouseId)->whereNull('brand')->exists()) {
                            $data = $this->isVolume(PriceIndex::where('itemCode', $itemCode)->where('warehouse_origin_id',$warehouseId), $volume);
                            // echo "check item and warehouse";
                        }else{
                            $data = $this->isVolume(PriceIndex::where('itemCode', $itemCode)->whereNull('warehouse_origin_id'), $volume);
                            // echo "last query 1";
                        }
                    }
            }

        } else {

            if(PriceIndex::where('itemCode', $itemCode)->whereNull('warehouse_origin_id')->exists() && $company==='RH'){
                $data = $this->isVolume($query->whereNull('warehouse_origin_id')->where('company', $company), $volume);
            }else{
                $data = $this->isVolume($query->whereNull('warehouse_origin_id'), $volume);
            }

            // echo "last query 2";
        }

        return $data;
    }


    public function isVolume($query,$volume){

        $data = ($volume=="YES") ? $query->first(['volumePrice as pickupPrice','sku']) : $data = $query->first(['pickupPrice', 'sku']);

        return $data;
    
    }

}