<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Costing;
use App\Models\truckrate;
use App\Models\Trucktype;
use App\Models\WarehouseOrigin;
use Barryvdh\DomPDF\Facade\Pdf;

class CostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trucktype =Trucktype::get(['id','capacity','trucktype']);
        $warehouseOrigin = WarehouseOrigin::get(['id','warehouse']);
        return view('pages.costing.index',compact('warehouseOrigin','trucktype'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->merge(['costingNo' => Costing::setPrefixSeries('C')]);
        $data =  Costing::storeCosting($request);
        return $data;
    }

    /**
     * Display the specified resource.
     */



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

    

    public function exportPdf()
    {
        $pdf = Pdf::loadView('reports.ecostingreport');
        return $pdf->download('invoice.pdf');
    }


    public function list(Request $request){

        $search = $request->query('search', array('value' => '', 'regex' => false));
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));
    
        $filter = $search['value'];
        $query = Costing::select("costing.*", "trucktype.trucktype", "warehouse_origin.warehouse")
            ->join('warehouse_origin', 'costing.warehouse_origin_id', '=', 'warehouse_origin.id')
            ->join('trucktype', 'costing.trucktype_id', '=', 'trucktype.id');
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
                ->orwhere('quantity','like','%'.$filter.'%')
                ->orwhere('pickupprice','like','%'.$filter.'%')
                ->orwhere('analysisFee','like','%'.$filter.'%')
                ->orwhere('plasticLiner','like','%'.$filter.'%')
                ->orwhere('twoDrops','like','%'.$filter.'%')
                ->orwhere('parking','like','%'.$filter.'%')
                ->orwhere('trucking','like','%'.$filter.'%')
                ->orwhere('additionalTrucking','like','%'.$filter.'%')
                ->orwhere('tollFee','like','%'.$filter.'%')
                ->orwhere('allowance','like','%'.$filter.'%')
                ->orwhere('loading','like','%'.$filter.'%')
                ->orwhere('brand','like','%'.$filter.'%')
                ->orwhere('unloading','like','%'.$filter.'%')
                ->orwhere('additionalUnloading','like','%'.$filter.'%')
                ->orwhere('terms','like','%'.$filter.'%')
                ->orwhere('cleaning','like','%'.$filter.'%')
                ->orwhere('entryFee','like','%'.$filter.'%')
                ->orwhere('emptySack','like','%'.$filter.'%')
                ->orwhere('sticker','like','%'.$filter.'%')
                ->orwhere('escort','like','%'.$filter.'%')
                ->orwhere('bankCharge','like','%'.$filter.'%')
                ->orwhere('commision','like','%'.$filter.'%')
                ->orwhere('serviceFee','like','%'.$filter.'%')
                ->orwhere('allowanceWeight','like','%'.$filter.'%')
                ->orwhere('truckScale','like','%'.$filter.'%')
                ->orwhere('grossprice','like','%'.$filter.'%')
                ->orwhere('rate','like','%'.$filter.'%')
                ->orwhere('sku','like','%'.$filter.'%')
                ->orwhere('paymentMode','like','%'.$filter.'%')
                ->orwhere('taxCode','like','%'.$filter.'%')
                ->orwhere('specialPrice','like','%'.$filter.'%')
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
        return view('pages.costing.list');
    }
    

    public function prevTransaction(Request $request){
        return $this->list($request);
    }


    public function loadCosting(Request $request){
        return $this->list($request);
    }

    public function brand(Request $request){
         return DB::select("exec dbo.sp_brandlist ?",array($request->input('itemcode')));
    }

}
