@extends('../layout/app')
@section('css')
<link rel="stylesheet" href="{{ asset('costing-new/costing.css') }}">   
@endsection
@section('content')
<x-title title="COSTING"></x-title>
<form action="{{ route('costing.new.store') }}" id="CostingForm" autocomplete="off" novalidate>
    <div class="row">
           <div class="col-lg-12">
                <div class="card">
                    <div class="card-body px-2 py-2">
                        <div class="row">
                            <div class="col-4">
                                <fieldset class="form-fieldset" id="myTable" data-url="{{ route('api_priceindex') }}">
                                    <div class="mb-3">
                                        <small class="text-primary float-end copyCosting" style="cursor: pointer;font-size:11px">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-copy">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                <path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                                </svg> Copy Costing
                                        </small>
                                        <small class="text-danger text-msg float-end" style="animation: blinker 1s infinite; opacity: 1;"></small>
                                      <label class="form-label required">Client</label>
                                      <select class="form-control " data-url="{{ route('api_clients') }}" name="client" style="width: 100%" required></select>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Warehouse</label>
                                                <select name="warehouse_origin_id"  class="form-control">
                                                      @foreach ($warehouseOrigin as $item)
                                                          <option value="{{ $item->id }}">{{  $item->warehouse }}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                            <label class="form-label required">Province</label>
                                            <select class="form-control" name="province" required style="width: 100%" data-url="{{ asset('location/refprovince.json') }}">
                                                <option value=""></option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Area</label>
                                                <select class="form-control" name="municipality" required style="width: 100%" data-url="{{ asset('location/refcitymun.json') }}">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                            <label class="form-label required">Truck Type</label>
                                            <select name="trucktype_id" class="form-control" required>
                                                <option value="" data-capacity="0"></option>
                                                @foreach ($trucktype as $item)
                                                    <option value="{{ $item->id }}" data-capacity="{{ $item->capacity }}">{{  $item->trucktype }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control d-none" name="rate">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Truck Category</label>
                                                <select class="form-control"  name="truckCategory">
                                                    <option value="NA">NA</option>
                                                    <option value="WINGED VAN">WINGED VAN</option>
                                                    <option value="DROP SIDE">DROP SIDE</option>
                                                    <option value="WINGED VAN/DROP SIDE">WINGED VAN/DROP SIDE</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Payment Mode</label>
                                                <select class="form-control" name="paymentMode">
                                                    <option value="NA">NA</option>
                                                    <option value="CASH">CASH</option>
                                                    <option value="CHECK">CHECK</option>
                                                    <option value="ONLINE">ONLINE</option>
                                                    <option value="TERMS">TERMS</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                            <label class="form-label required">Form</label>
                                            <select class="form-control" name="form">
                                                <option value="INVOICE">INVOICE</option>
                                                <option value="STATEMENT">STATEMENT</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Company</label>
                                                <select class="form-control" name="company">
                                                    <option value="ARVIN">ARVIN</option>
                                                    <option value="RH">RH</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Delivery Type</label>
                                                <select class="form-control" name="deliveryType">
                                                    <option value="ONETIMEDELIVERY">ONE TIME DELIVERY</option>
                                                    <option value="STAGGERED">STAGGERED</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                  </fieldset>
                            </div>
                            <div class="col-8">
                                <fieldset class="form-fieldset">
                                    <div class="col mb-3">
                                        <label class="form-label required">Item Name</label>
                                        <select class="form-control " name="itemName" data-url="{{ route('api_items') }}" style="width: 100%"></select>
                                        <input type="text" class="form-control d-none" name="sku">
                                        <input type="text" class="form-control d-none" name="itemCode">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Quantity</label>
                                                <input type="text" class="form-control" name="quantity">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Tax Code</label>
                                                <select class="form-control " name="taxCode">
                                                    <option value="OVAT-C">OVAT-C</option>
                                                    <option value="OVAT-E">OVAT-E</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Special Price</label>
                                                <select class="form-control " name="specialPrice">
                                                    <option value="NO">NO</option>
                                                    <option value="YES">YES</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Volume Price</label>
                                                <select class="form-control " name="volumePrice">
                                                    <option value="NO">NO</option>
                                                    <option value="YES">YES</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                {{-- <label class="form-label required">Pickup Price</label> --}}
                                                {{-- <input type="text" class="form-control not-allowed" name="pickupPrice" data-url="{{ route('api_showPickupPrice') }}" readonly> --}}
                                                <label class="form-label required">Pickup Price</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control not-allowed" name="pickupPrice" data-url="{{ route('api_showPickupPrice') }}" readonly>
                                                    {{-- <select class="form-control dropdown-menu-end">
                                                      @foreach ($condition as $item)
                                                          <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                                      @endforeach
                                                    </select> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Brand</label>
                                                <select name="brand" class="form-control" data-url="{{ route('costing.brand') }}"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Trucking</label>
                                                <input type="text" class="form-control" name="trucking" data-url="{{ route('api_getTruckRate') }}" value="" readonly>
                                            </div>
                                           
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Total Costing</label>
                                                <input type="text" class="form-control " name="totalCosting" value="0" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label for=""></label>
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="d-grid gap-0 mt-0">
                                                            <button class="btn btn-outline-secondary" type="button" name="more" style="font-size:12px">More Field</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="d-grid gap-0 mt-0">
                                                            <button class="btn btn-primary" name="addRow" type="button" data-edit="N" data-id="" style="font-size:12px"> Add Costing </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="table-responsive">
                          

                            <table id="myTable" class="table table-bordered table-hover">
                                <thead class="sub-header">
                                    <tr class="text-center ">
                                        <th  class="py-4" colspan="12" style="font-size: 13px"><small></small></th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr >
                                        <th>Item Description <small class="text-primary float-end itemCode" style="cursor: pointer"></small></th>
                                        <th width="5%">Quantity</th>
                                        <th width="10%">Tax Code</th>
                                        <th width="8%">Special Price </th>
                                        <th width="8%">Volume Price </th>
                                        <th width="7%">Pickup Price</th>
                                        <th width="8%">Brand</th>
                                        <th width="8%">Trucking Rate</th>
                                        <th width="12%">Total</th>
                                        <th width="2%">More</th>
                                        <th width="2%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td colspan="12"><em>No data available</em></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" class=""></th>
                                        
                                        {{-- <th>
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                  <input class="form-check-input mt-0" name="isCoload" type="checkbox">
                                                </div>
                                                <input type="number" class="form-control not-allowed" readonly placeholder="Quantity" name="coloadQuantity">
                                              </div>
                                        </th>
                                        --}}
                                        <th class="">
                                            <div class="d-grid gap-1">
                                                <input type="text" class="form-control" placeholder="Co-load in kls" name="coloadInKls">
                                            </div>
                                        </th>
                                        <th class="">
                                            <div class="d-grid gap-1">
                                                <input type="text" class="form-control not-allowed" placeholder="Total" readonly value="0" name="totalNumCosting">
                                            </div>
                                        </th>
                                        <th colspan="2">
                                            <div class="d-grid gap-1">
                                            <button class="btn btn-success" type="submit">Submit</button>
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
           </div>
         
    </div>
    {{-- @include('pages.costing-new.parts.coload')     --}}
    @include('pages.costing-new.parts.more')    
    @include('pages.costing-new.parts.copy')    
</form>
@endsection
@section('script')
<script src="{{ asset('assets/datatable/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('assets/datatable/js/responsive.bootstrap5.js') }}"></script>
<!-- Libs JS -->
<script src="{{ asset('costing-new/costing.js') }}"></script>

@endsection
