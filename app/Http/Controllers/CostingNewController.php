<?php

namespace App\Http\Controllers;

use App\Models\Costing;
use App\Models\CostingHeader;
use App\Models\truckrate;
use App\Models\Trucktype;
use App\Models\WarehouseOrigin;
use Carbon\Carbon;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use App\Services\CostingService;

class CostingNewController extends Controller
{

    public $costingService;
    public function __construct(CostingService $costingService)
    {
        $this->costingService = $costingService;
    }

    public function index(){
        $trucktype =Trucktype::get(['id','capacity','trucktype']);
        $warehouseOrigin = WarehouseOrigin::get(['id','warehouse']);
        $condition = array(
            [
                'label' => 'Regular Price',
                'value' => 'regularPrice'
            ],
            [
                'label' => 'Base On Company',
                'value' => 'baseOnCompany'
            ],
            [
                'label' => 'Retail Price',
                'value' => 'baseOnCompany'
            ],
            [
                'label' => '',
                'value' => 'baseOnCompany'
            ],
        );
        return view('pages.costing-new.index',compact('warehouseOrigin','trucktype','condition'));
    }

    public function store(Request $request)
    {
        $arrInput = ['client','form','company','municipality','paymentMode','province','truckCategory','trucktype_id','warehouse_origin_id','coloadQuantity','deliveryType'];
        $requestData = $request->only($arrInput);
        $requestData['costingHeaderNo']  = CostingHeader::setPrefixSeries('H');
        $costing_heading = CostingHeader::create($requestData)->id;

        $costings  = collect(json_decode($request->input('costing', '[]')));
        $data      = array();

        $costingNo = Costing::setPrefixSeries('C',true,count($costings)); 
         for ($i=0; $i <count($costings) ; $i++) { 
            $data[] = [
                'costing_header_id'  => $costing_heading,
                'costingNo'          => $costingNo[$i],
                'itemName'           => $costings[$i]->itemName,
                'brand'              => $costings[$i]->brand,
                'itemCode'           => $costings[$i]->itemCode,
                'taxCode'            => $costings[$i]->taxCode,
                'totalCosting'       => $costings[$i]->totalCosting,
                'specialPrice'       => $costings[$i]->specialPrice,
                'volumePrice'        => $costings[$i]->volumePrice,
                'quantity'           => $costings[$i]->quantity,
                'sku'                => $costings[$i]->sku,
                'pickupPrice'        => $costings[$i]->pickupPrice,
                'trucking'           => $costings[$i]->trucking,
                
                'analysisFee'        => floatval($costings[$i]->analysisFee ?? NULL),
                'plasticLiner'       => floatval($costings[$i]->plasticLiner ?? NULL),
                'twoDrops'           => floatval($costings[$i]->twoDrops ?? NULL),
                'parking'            => floatval($costings[$i]->parking ?? NULL),
                'additionalTrucking' => floatval($costings[$i]->additionalTrucking ?? NULL),
                'tollFee'            => floatval($costings[$i]->tollFee ?? NULL),
                'allowance'          => floatval($costings[$i]->allowance ?? NULL),
                'loading'            => floatval($costings[$i]->loading ?? NULL),
                'unloading'          => floatval($costings[$i]->unloading ?? NULL),
                'additionalUnloading'=> floatval($costings[$i]->additionalUnloading ?? NULL),
                'terms'              => floatval($costings[$i]->terms ?? NULL),
                'cleaning'           => floatval($costings[$i]->cleaning ?? NULL),
                'entryFee'           => floatval($costings[$i]->entryFee ?? NULL),
                'emptySack'          => floatval($costings[$i]->emptySack ?? NULL),
                'others'             => floatval($costings[$i]->others ?? NULL),
                'sticker'            => floatval($costings[$i]->sticker ?? NULL),
                'escort'             => floatval($costings[$i]->escort ?? NULL),
                'bankCharge'         => floatval($costings[$i]->bankCharge ?? NULL),
                'commision'          => floatval($costings[$i]->commision ?? NULL),
                'serviceFee'         => floatval($costings[$i]->serviceFee ?? NULL),
                'allowanceWeight'    => floatval($costings[$i]->allowanceWeight ?? NULL),
                'truckScale'         => floatval($costings[$i]->truckScale ?? NULL),
                "created_at"         => Carbon::now(),
                "updated_at"         => Carbon::now(), 
            ];
        }
    
        Costing::insert($data);
    }


    public function list(Request $request){

        $search = $request->query('search', array('value' => '', 'regex' => false));
        $draw   = $request->query('draw', 0);
        $start  = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order  = $request->query('order', array(1, 'asc'));
    
        $filter = $search['value'];
        $query  =  CostingHeader::with(['costing','warehouseOrigin:id,warehouse','trucktype:id,trucktype,capacity']);
        if ($request->has('grant') && $request->input('grant') != 'all') {
            $query->where("user_id", auth()->id());
        }        
        if ($request->has('client') && $request->has('itemCode')) {
            $query
            ->where('client', $request->input('client'))
            ->where('itemCode', $request->input('itemCode'));
        }

        if (!empty($filter)) {
            $query
            ->orwhere('province', 'like', '%'.$filter.'%')
            ->orwhere('client','like','%'.$filter.'%')
            ->orwhere('item','like','%'.$filter.'%')
            ->orwhere('brand','like','%'.$filter.'%')
            ->orwhere('unloading','like','%'.$filter.'%')
            ->orwhere('terms','like','%'.$filter.'%')
            ->orwhere('paymentMode','like','%'.$filter.'%')
            ->orwhere('form','like','%'.$filter.'%')
            ->orwhere('truckCategory','like','%'.$filter.'%')
            ->orwhere('truckerType','like','%'.$filter.'%')
            ->orwhere('deliveryType','like','%'.$filter.'%')
            ->orwhere('municipality','like','%'.$filter.'%')
            ->orwhere('costingNo','like','%'.$filter.'%');
        }
    
        $recordsTotal = $query->count();
    
    
        $query->take($length)->skip($start);

    

        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $query->get(),
        );

        return $json;

    }

    public function costingList()
    {
        return view('pages.costing-new.list');
    }

    public function getTruckRate(Request $request)
    {
        $truckRate = truckrate::join('trucktype', 'truckrate.trucktype_id', '=', 'trucktype.id')
            ->where('warehouse_origin_id', $request->input('warehouse'))
            ->where('province', $request->input('province'))
            ->where('municipality', $request->input('municipality'))
            ->where('trucktype_id', $request->input('trucktype'))
            ->first();

        $truckRate = $truckRate ? $truckRate->rate : 0;

        return response()->json([
            'res' => $truckRate
        ],200);
    }

    public function finalRate(Request $request){

        $sku          = $request->input('sku');
        $rate         = $request->input('rate');
        $capacity     = $request->input('capacity');
        $quantity     = $request->input('quantity');
        //-----------------------------------------
        $simpleRateFormula  = ($sku/50)*$rate;
        
        if (!empty($quantity) && !empty($capacity)) {
            $final  = $capacity/($sku*$quantity) * $simpleRateFormula;
        }else{
            $final  = $simpleRateFormula;
        }
        //-----------------------------------------
        return number_format((float)($final), 5, '.', '');
    }

    public function copyCosting(CostingHeader $costingHeader){
        $data     = array();
        $capacity = $costingHeader->trucktype->capacity;
        
        $response = $this->getTruckRate(new Request([
            'warehouse'     => $costingHeader->warehouse_origin_id,
            'province'      => $costingHeader->province,
            'municipality'  => $costingHeader->municipality,
            'trucktype'     => $costingHeader->trucktype_id,
        ]))->getContent();

        $rate = json_decode($response, true);

        foreach ($costingHeader->costing as $key => $value) {
            if ($key == 'trucking') {
                $request = new Request([
                    'sku' => $value->sku,
                    'rate' => $rate,
                    // 'capacity' => $capacity,
                    // 'quantity' => $value->quantity,
                ]);
                $data['trucking'] = $this->finalRate($request);
            }else if ($key == 'pickupPrice') {
                $data['pickupPrice'] = $this->costingService->getPrice($value->itemCode,
                                            $costingHeader->warehouse_origin_id,
                                            $value->brand,
                                            $value->taxCode,
                                            $costingHeader->warehouse_origin_id,
                                            $value->volume);
            }else{
                $data[$key] = $value;
            }
        }

        return response([
            'header'=> $costingHeader,
            'body'  => $data,

        ],200);
    }

    public function recomputeTruckingRateCosting(){
        
        
        
    }
}
