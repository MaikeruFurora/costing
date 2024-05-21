<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\TruckTypeController;
use App\Http\Controllers\TruckRateController;
use App\Http\Controllers\CostingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CostingNewController;
use App\Http\Controllers\UserController;

Route::middleware(['guest:web', 'preventBackHistory'])->name('auth.')->group(function () {
    Route::get('/', function () {
        return redirect('item');
        return view('auth/signin');
    })->name('login');
    Route::post('/post', [AuthController::class, 'loginPost'])->name('login.post');
});


// Route::middleware(['auth:web','preventBackHistory','auth.user'])->prefix('auth/')->group(function(){
    Route::get('/client', function () {
        return view('pages.client');
    })->name('p_client');
    
  

    //client
    Route::post('client/store', [ClientController::class, 'store'])->name('clients_store');
    Route::get('api/clients', [ClientController::class, 'show'])->name('api_clients');
    Route::get('api/showClients', [ClientController::class, 'showClients'])->name('api_showClients');

    //items
    Route::get('item', [ItemController::class, 'index'])->name('item');
    Route::post('item/store', [ItemController::class, 'store'])->name('item.store');
    Route::get('api/item', [ItemController::class, 'Show'])->name('api_items');
    Route::get('api/showPickupPrice', [ItemController::class, 'showPickupPrice'])->name('api_showPickupPrice');
    Route::post('api/getItems/{warehouse}', [ItemController::class, 'getItems'])->name('api_getItems');
    Route::get('api/priceindex', [ItemController::class, 'showPriceIndex'])->name('api_priceindex');

    //Trucking
    Route::get('api/trucktype', [TruckTypeController::class, 'Show'])->name('api_trucktype');

    Route::get('truckingrate', [TruckRateController::class, 'index'])->name('truckingrate');
    Route::post('truckmatrix/store', [TruckRateController::class, 'store'])->name('truckmatrix_store');
    Route::get('api/truckrate', [TruckRateController::class, 'Show'])->name('api_showtruckrate');
    //group area
    Route::post('grouparea/store', [TruckRateController::class, 'storeGroupArea'])->name('grouparea.store');
    Route::get('grouparea/list', [TruckRateController::class, 'listGroupArea'])->name('grouparea.list');


    Route::get('api/warehouselist', [WarehouseController::class, 'Show'])->name('api_warehouselist');

    Route::get('costings', [CostingController::class, 'index'])->name('costing');
    Route::post('costing/store', [CostingController::class, 'store'])->name('costing.store');
    Route::get('costing/view', [CostingController::class, 'costingList'])->name('costing.view');
    Route::get('costing/brand', [CostingController::class, 'brand'])->name('costing.brand');
    //costing list of data
    Route::post('costing/list-data', [CostingController::class, 'list'])->name('costing.list');
    //costing prev transaction
    Route::get('costing/prev/transaction', [CostingController::class, 'prevTransaction'])->name('costing.prev.transaction');
    Route::get('costing/load', [CostingController::class, 'loadCosting'])->name('costing.load');
    Route::get('api/exportPdf/', [CostingController::class, 'exportPdf'])->name('api_exportPdf');
    
    
    //new costing
    Route::post('api/getTruckRate/', [CostingNewController::class, 'getTruckRate'])->name('api_getTruckRate');
    Route::get('costing/new', [CostingNewController::class, 'index'])->name('costing.new');
    Route::post('costing/new/store', [CostingNewController::class, 'store'])->name('costing.new.store');
    Route::post('costing/new/list', [CostingNewController::class, 'list'])->name('costing.new.list');
    Route::get('costing/new/vw', [CostingNewController::class, 'costingList'])->name('costing.new.view');
    Route::get('costing/copy/{costingHeader}', [CostingNewController::class, 'copyCosting'])->name('costing.copy');
    Route::get('costing/finalRate', [CostingNewController::class, 'computedRate'])->name('costing.finalRate');
    Route::get('costing/recompute-trucking', [CostingNewController::class, 'computedFinalRate'])->name('costing.recompute-trucking');
     //signout
    //  Route::post('signout', [UserController::class, 'signout'])->name('signout');
// });