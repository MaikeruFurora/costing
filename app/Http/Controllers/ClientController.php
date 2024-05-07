<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $client = new Client();
        $client->name = $request->input('client');
        $client->province = $request->input('province');
        $client->municipality = $request->input('muni');
        $client->type = $request->input('type');
        $client->active = 'active';
        $client->alias =  $request->input('client').'-'.$request->input('muni');
        $client->save();

        return response()->json([
            'msg' => "success",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {   
        $data = DB::table('v_clients')->limit(10);
        if($request->has('q')){
            return $data->where('cardname', 'like', '%'.$request->input('q').'%')->get();
        }else{
            return $data->get();
        }
    }

    public function showClients()
    {
        $data = DB::table('clients')
        ->select(DB::raw('name,province,municipality,type,active,alias'))
        ->get();

        return response()->json([
            'data' =>$data,
        ], 200);
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
