<?php

namespace App\Http\Controllers;

use App\Models\GroupArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Truckrate;
use App\Models\Trucktype;
use App\Models\WarehouseOrigin;
use PHPUnit\TextUI\XmlConfiguration\Group;

class TruckRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupArea       = GroupArea::get(['id','area']);
        $trucktype       = Trucktype::get(['id','trucktype']);
        $warehouseOrigin = WarehouseOrigin::get(['id','warehouse']);
        return view('pages.truckingrate',compact('trucktype','warehouseOrigin','groupArea'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $id = $request->input('id');
        if(!empty($id) && $request->status!='update'){
            Truckrate::where('id', $id)->update($this->requestInput($request));
        }else{
            Truckrate::create($this->requestInput($request));
        }
        return response()->json([
            'msg' => "success",
        ], 200);
        
    }


    public function requestInput($request){
        return [
            'warehouse_origin_id'   => $request->input('warehouse_origin_id'),
            'group_area_id'         => $request->input('grouparea_id'),
            'province'              => $request->input('province'),
            'municipality'          => $request->input('municipality'),
            'trucktype_id'          => $request->input('trucktype_id'),
            'rate'                  => $request->input('rate'),
            'active'                => $request->input('active'),
        ];
    }

    /**
     * Display the specified resource.
     */
   
    public function show(Request $request){

            $search = $request->query('search', array('value' => '', 'regex' => false));
            $draw = $request->query('draw', 0);
            $start = $request->query('start', 0);
            $length = $request->query('length', 25);
            $order = $request->query('order', array(1, 'asc'));
        
            $filter = $search['value'];
            $query = Truckrate::select([ 'truckrate.id as id','warehouse_origin_id','group_area_id',
                'warehouse_origin.warehouse as warehouse',
                'trucktype.trucktype as trucktype',
                'group_areas.area as area',
                'province',
                'municipality',
                'rate',
                'active',
                'trucktype_id',
            ])
            ->join('warehouse_origin', 'truckrate.warehouse_origin_id', '=', 'warehouse_origin.id')
            ->join('trucktype', 'truckrate.trucktype_id', '=', 'trucktype.id')
            ->leftjoin('group_areas', 'truckrate.group_area_id', '=', 'group_areas.id');
 
            if (!empty($request->warehouse)) {
                $query->where('warehouse_origin_id', $request->warehouse);
            }
    
            if (!empty($request->active)) {
                $query->where('active', $request->active);
            }
    
            if (!empty($request->trucktype)) {
                $query->where('trucktype_id', $request->trucktype);
            }

            if (!empty($request->group_area)) {
                $query->where('group_area_id', $request->group_area);
            }

            if (!empty($filter)) {
                $query->where(function($query) use ($filter) {
                    $query->where('province', 'like', '%'.$filter.'%')
                    ->orwhere('municipality', 'like', '%'.$filter.'%')
                    ->orwhere('trucktype', 'like', '%'.$filter.'%')
                    ->orwhere('warehouse', 'like', '%'.$filter.'%')
                    ->orwhere('rate', 'like', '%'.$filter.'%')
                    ->orwhere('active', 'like', '%'.$filter.'%');
                });
            }
        
            $recordsTotal = $query->count();
        
        
            $query->take($length)->skip($start);

        
            $json = array(
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsTotal,
                'data' => [],
            );
        
            $products = $query->get();
            
            foreach ($products as $value) {
            
                    $json['data'][] = [
                        "id"               => $value->id,
                        "warehouse"        => $value->warehouse,
                        "warehouse_id"     => $value->warehouse_origin_id,
                        "trucktype_id"     => $value->trucktype_id,
                        "grouparea_id"    => $value->group_area_id,
                        "province"         => $value->province,
                        "municipality"     => $value->municipality,
                        "trucktype"        => $value->trucktype,
                        "rate"             => $value->rate,
                        "active"           => $value->active,
                        "area"             => $value->area,
                    ];
            }

            return $json;

    }

    public function storeGroupArea(Request $request){

        $area = strtoupper($request->input('area'));
        $groupArea = GroupArea::firstOrCreate(['area' => $area]);

        return response()->json([
            'data'=> $groupArea,
            'msg' => $groupArea ? 'Created' : 'Already exists',
        ], $groupArea ? 200 : 204);

    }

    public function listGroupArea(Request $request){

        $search = strtoupper($request->q);

        $data = GroupArea::where('area','like','%'.$search.'%')->orderBy('area','asc')->get(['area','id']);

        return response()->json([
            'data' => $data,
            'msg' => "success",
        ],200);

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
