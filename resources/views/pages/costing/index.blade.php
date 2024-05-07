@extends('../layout/app', ['title' => 'Adjustment'])
@section('css')
    <style>
        .form-label{
            margin-bottom: 1px !important;
            font-size:12px
        }
        .dt-search>label{
            display: none;
        }
    </style>
@endsection
@section('content')

<div class="row">

    <div class="col-12">
      
        <form action="{{ route('costing.store') }}" id="costingForm" autocomplete="off">@csrf
           <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header py-1 bg-light" style="font-size: 11px;font-weight: bold">
                            Basic Information
                        </div>
                        <div class="card-body pb-1">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 ">
                                           <div class="mb-3">
                                                <label class="form-label ">Client 
                                                    <a class="float-end" style="font-size:10px;cursor:pointer" id="prevTransaction">
                                                        Click here to view previous transactions.
                                                    </a>
                                                </label>
                                                <select class="form-control " data-url="{{ route('api_clients') }}" name="client" required></select>
                                           </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Item Description
                                                    <small class="text-danger text-msg float-end" style="animation: blinker 1s infinite; opacity: 1;">
                                                      
                                                    </small>
                                                </label>
                                                <select class="form-control" data-url="{{ route('api_items') }}" name="item" required></select>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label ">Quantity</label>
                                                <input type="number" step="0.01" min="0.01" class="form-control" name="quantity" value="0.00" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label ">Tax Code</label>
                                                <select class="form-control" name="taxCode">
                                                    <option value="OVAT-C">OVAT-C</option>
                                                    <option value="OVAT-E">OVAT-E</option>
                                                </select>
                                            </div>
                                        </div>
                                      
                                        <div class="col-lg-2 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label ">Pickup Price</label>
                                                <input type="text" class="form-control group-sum"  onblur="" value="0.00"  name="pickupprice" data-url="{{ route('api_showPickupPrice') }}"  readonly/>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label ">Special Price</label>
                                                <select class="form-control" name="specialPrice">
                                                    <option value="NO">NO</option>
                                                    <option value="YES">YES</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Brand</label>
                                                {{-- <input type="text" class="form-control" name="brand" readonly/> --}}
                                                <select name="brand" class="form-control" data-url="{{ route('costing.brand') }}"></select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 d-none">
                                            <div class="mb-3">
                                                <label class="form-label">SKU</label>
                                                <input type="text" class="form-control" name="sku" readonly/>
                                            </div>
                                        </div>
                                       
                                   </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header py-1 bg-light" style="font-size: 11px;font-weight: bold">
                            Trucking Rate
                        </div>
                        <div class="card-body pb-1">
                           <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Warehouse</label>
                                    <select name="warehouse_origin_id"  class="form-control">
                                        @foreach ($warehouseOrigin as $item)
                                            <option value="{{ $item->id }}">{{  $item->warehouse }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Province</label>
                                    <select class="form-control" name="province" required></select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Area</label>
                                    <select class="form-control" name="municipality" required></select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Truck Type</label>
                                    <select name="trucktype_id" class="form-control" required>
                                        <option value="" data-capacity="0"></option>
                                        @foreach ($trucktype as $item)
                                            <option value="{{ $item->id }}" data-capacity="{{ $item->capacity }}">{{  $item->trucktype }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label ">Trucking</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control group-sum" name="trucking" readonly required data-url="{{ route('api_getTruckRate') }}">
                                        {{-- <span class="input-group-text" data-bs-toggle="offcanvas" id="TruckingoffcanvasRight" role="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="10" height="10" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                        </span> --}}
                                    </div>
                                </div>
                            </div>
                           </div>
                        </div>
                    </div>
                </div>
           </div>
           
            <div class="card mt-2">
                <div class="card-body pb-1">
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label ">Analysis Fee</label>
                                <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="analysisFee" />
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label ">Plastic Liner</label>
                                <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="plasticLiner" />
                            </div>
                        </div>
                       <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="mb-3">
                            <label class="form-label ">2 Drops</label>
                            <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="twoDrops" />
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label ">Parking</label>
                                <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="parking"/>
                            </div>
                        </div>
                       
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label ">Add'l Trucking</label>
                                <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="additionalTrucking" />
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label ">Toll Fee</label>
                                <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="tollFee" />
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label ">Allowance</label>
                                <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="allowance" />
                            </div>
                        </div>
                       <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="mb-3">
                            <label class="form-label ">Loading</label>
                            <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="loading" />
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label ">Unloading</label>
                                <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="unloading" />
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label ">Additiional Unloading</label>
                                <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="additionalUnloading" />
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label ">Terms</label>
                                <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="terms" />
                            </div>
                       </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label ">Cleaning</label>
                                <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="cleaning" />
                            </div>
                        </div>
                   </div>  
                 
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                           <div class="row">
                                
                            
                            <div class="col-lg-2 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label ">Entry Fee</label>
                                    <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="entryFee" />
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label ">Empty Sack</label>
                                    <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="emptySack" />
                                </div>
                            </div>
                            {{--  --}}
                            <div class="col-lg-2 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label ">Sticker</label>
                                    <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="sticker" />
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-12">
                                <div class="mb-3">
                                <label class="form-label ">Escort</label>
                                <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="escort" />
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label ">Bank Charge</label>
                                    <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="bankCharge" />
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label ">Commision</label>
                                    <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="commision" />
                                </div>
                            </div>
                            {{--  --}}
                           </div>
                        </div>    
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body pb-0">
                    {{--  --}}
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                           {{--  --}}
                           <div class="row">
                                <div class="col-lg-1 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label ">Service Fee</label>
                                        <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="serviceFee" />
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label ">Allowance Weight</label>
                                        <input type="text" class="form-control group-sum"  onblur="" value="0.00"   name="allowanceWeight" />
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label ">Truck Scale</label>
                                        <input type="text" class="form-control group-sum" onblur="" value="0.00" name="truckScale" />
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label ">Others</label>
                                        <input type="text" class="form-control group-sum" onblur="" value="0.00" name="others" />
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label ">Payment Mode</label>
                                        <select class="form-control" name="paymentMode">
                                            <option value="NA">NA</option>
                                            <option value="CASH">CASH</option>
                                            <option value="CHECK">CHECK</option>
                                            <option value="ONLINE">ONLINE</option>
                                            <option value="TERMS">TERMS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                    <label class="form-label">Form</label>
                                    <select class="form-control" name="form">
                                        <option value="INVOICE">INVOICE</option>
                                        <option value="STATEMENT">STATEMENT</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label ">Truck Category</label>
                                        <select class="form-control"  name="truckCategory">
                                            <option value="NA">NA</option>
                                            <option value="WINGED VAN">WINGED VAN</option>
                                            <option value="DROP SIDE">DROP SIDE</option>
                                            <option value="WINGED VAN/DROP SIDE">WINGED VAN/DROP SIDE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label ">Trucker Type</label>
                                       <div class="input-group">
                                            <select class="form-control" name="truckerType">
                                                <option value="REGULAR">REGULAR</option>
                                                {{-- <option value="BACKLOAD">BACKLOAD</option> --}}
                                                <option value="COLOAD">COLOAD</option>
                                            </select>
                                            <span class="input-group-text" id="truckerTypeButton" role="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="10" height="10" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                            </span>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label ">Delivery Type</label>
                                        <select class="form-control" name="deliveryType">
                                            <option value="DELIVERY">DELIVERY</option>
                                            <option value="STAGGERED">STAGGERED</option>
                                            <option value="PICK-UP">PICK-UP</option>
                                        </select>
                                    </div>
                                </div>
                               
                            </div>
                        </div>    
                    </div>
                    {{--  --}}
                </div>
                <div class="card-footer p-1">
                    <div class="row justify-content-between">
                        <div class="col-lg-2 col-md-12 col-sm-12 px-5 py-1">
                            <div class="input-group">
                                <span class="input-group-text">
                                    Gross Price
                                </span>
                                <input type="text" class="form-control"  placeholder="" name="grossprice"  autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12 px-5 py-1">
                            <div class="d-grid gap-1 col-12 mx-auto">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </form>
    </div>
</div>

@include('pages.costing.parts.tracking-rate',['warehouse'=>$warehouseOrigin,'trucktype'=>$trucktype])
@include('pages.costing.parts.view-transaction')
@include('pages.costing.parts.load')

@endsection
@section('script')
<script src="{{ asset('assets/datatable/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('assets/datatable/js/responsive.bootstrap5.js') }}"></script>
<!-- Libs JS -->
<script src="{{ asset('dist/libs/list.js/dist/list.min.js') }}"></script>
<script src="{{ asset('costing/index.js') }}"></script>
<script src="{{ asset('costing/load.js') }}"></script>
@endsection
