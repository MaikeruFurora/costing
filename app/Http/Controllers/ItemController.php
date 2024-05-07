<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\PriceIndex;
use App\Models\PriceIndexLog;
use App\Models\WarehouseOrigin;
use App\Services\CostingService;

class ItemController extends Controller
{

    public $costingService;
    public function __construct(CostingService $costingService)
    {
        $this->costingService = $costingService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouseOrigin = collect([
            (object)['id' => null, 'warehouse' => 'ALL']
        ])->merge(WarehouseOrigin::get(['id','warehouse']));
        return view('pages.item',compact('warehouseOrigin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $id        = $request->input('id');
        $status    = $request->input('status');
        $warehouse = $request->input('warehouse_origin_id');
        $itemCode  = $request->input('itemCode');
        $company   = $request->input('company');
        $flag      = true;
      
            if(!empty($id) && $status=='update'){
                PriceIndex::where('id', $id)->update($this->requestInput($request));
            }else{
                if (
                PriceIndex::where('itemCode', $itemCode)
                        ->where('warehouse_origin_id', $warehouse)
                        ->where('company', $company)
                        ->doesntExist()
                ) {
                    PriceIndex::create($this->requestInput($request));
                }else{
                    $flag=false;
                    return response()->json([
                        'msg'    => "Already Exist",
                        'status' => false,
                    ], 200);
                }
            }
         
            if ($flag) {
                $inputData           = $this->requestInput($request);
                $inputData['action'] = strtoupper($status);
                PriceIndexLog::create($inputData);
            }
            
            return response()->json([
                'msg'    => "Successfully saved",
                'status' => true,
            ], 200);

    }

    public function requestInput($request){
        return [
            'itemCode'              =>  strtoupper($request->input('itemCode')),
            'itemName'              =>  strtoupper($request->input('itemName')),
            'company'               =>  $request->input('company'),
            'pickupPrice'           =>  $request->input('pickupPrice'),
            'volumePrice'           =>  $request->input('volumePrice'),
            'condition'             =>  $request->input('condition'),
            'quantity'              =>  $request->input('quantity'),
            'sku'                   =>  $request->input('sku'),
            'warehouse_origin_id'   =>  $request->input('warehouse_origin_id'),
            'brand'                 =>  $request->input('brand'),
            'taxCode'               =>  $request->input('taxCode'),
            'area'                  =>  $request->input('area'),
            'basis'                 =>  $request->input('basis'),
        ];
    }

    public function show(Request $request)
    {
        $data = DB::table('v_itemlist')->OrderBy('itemname', 'ASC')->limit(10);
        if($request->has('q')){
            return $data->where('itemname', 'like', '%'.$request->input('q').'%')->get();
        }else{
            return $data->get();
        }
    }

   
    public function showPriceIndex(Request $request)
    {
        $search = $request->query('search', ['value' => '', 'regex' => false]);
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $orderCol = $request->query('columns.' . $request->query('order.0.column') . '.data');

        $filter = $search['value'];
        $query = PriceIndex::
        select('price_index.id','area','basis','brand','company','itemCode','itemName','volumePrice','condition','quantity','pickupPrice','sku','taxCode','warehouse','warehouse_origin_id')
        ->leftjoin('warehouse_origin', 'price_index.warehouse_origin_id', '=', 'warehouse_origin.id');

       
        
        if (!empty($filter)) {
            $query->where(function($query) use ($filter) {
                $query->where('itemCode', 'LIKE', "%{$filter}%")
                    ->orWhere('itemName', 'LIKE', "%{$filter}%")
                    ->orWhere('warehouse','LIKE',"%{$filter}%")
                    ->orWhere('brand', 'LIKE', "%{$filter}%");
            });
        }


        if (!empty($request->warehouse)) {
            $query->where('warehouse_origin_id', $request->warehouse);
        }

        if (!empty($request->company)) {
            $query->where('company', $request->company);
        }

        if (!empty($request->condition)) {
            $query->where('condition', $request->condition);
        }

        if (!empty($request->taxcode)) {
            $query->where('taxcode', $request->taxcode);
        }

        $recordsTotal = $query->count();
        
        $query->take($length)->skip($start);

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $query->get(),
        ];

        return $json;
    }


    public function showPickupPrice(Request $request)
    {
        $itemCode    = $request->input('item');
        $warehouseId = $request->input('warehouse');
        $brand       = $request->input('brand');
        $taxCode     = $request->input('taxCode');
        $company     = $request->input('company');
        $volume      = $request->input('volumePrice');
        $data        = $this->costingService->getPrice($itemCode, $warehouseId, $brand, $taxCode, $company, $volume);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
