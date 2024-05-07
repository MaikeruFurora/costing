@extends('../layout/app')
@section('content')
<x-title title="COSTING LIST"></x-title>
<div class="row">
    <div class="col">
        <div class="card ">
            <div class="card-body px-2 py-0">
                <div class="row">
                    <div class="col-12">
                        <br>
                        <table class="table table-bordered table-hover nowrap" id="myTable" data-url="{{ route('costing.new.list') }}"  style="font-size: 10px">
                            <thead  style="font-size: 8px">
                                <tr>
                                    <th width="2%">No.</th>
                                    <th>Client</th>
                                    <th width="3%">Warehouse</th>
                                    <th width="5%">Province</th>
                                    <th width="3%">Municipality</th>
                                    <th width="5%">Payment Mode</th>
                                    <th width="5%">truck Category</th>
                                    <th width="5%">Truck Type</th>
                                    {{-- <th width="5%">delivery Type</th> --}}
                                    <th width="3%">form</th>
                                    <th>Item</th>
                                    <th width="2%">Action</th>
                                </tr>
                                </thead>
                                <tbody style=" cursor: pointer;">
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.costing.parts.view-costing')
@endsection

@section('script')
<script src="{{ asset('assets/datatable/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('assets/datatable/js/responsive.bootstrap5.js') }}"></script>
<!-- Libs JS -->
<script src="./dist/libs/list.js/dist/list.min.js"></script>
<script src="{{ asset('costing-new/list.js') }}"></script>
@endsection