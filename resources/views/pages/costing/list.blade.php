@extends('../layout/app')
@section('content')
    <h1 class="h3 mb-3">Item List</h1>

    <div class="row">
        <div class="col">
            <div class="card ">
                <div class="card-body px-2 py-0">
                    <div class="row">
                        <div class="col-12">
                            <br>
                            <table class="table table-striped table-hover nowrap"  id="myTable" data-url="{{ route('costing.list') }}"  style="font-size: 10px">
                                <thead  style="font-size: 8px">
                                    <tr>
                                        <th width="5%">Costing No.</th>
                                        <th>Client</th>
                                        <th>Item</th>
                                        <th width="">Quantity</th>
                                        <th>Pickup Price</th>
                                        <th>payment Mode</th>
                                        <th width="5%">tax Code</th>
                                        <th>warehouse</th>
                                        <th>truck Category</th>
                                        <th>trucker Type</th>
                                        <th>delivery Type</th>
                                        <th>form</th>
                                        <th width="2%">Action</th>
                                        <th width="2%">Print</th>
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

<script>
   
   $(function(){
    let _token = Core.token;
    let table=$('#myTable').DataTable({
        responsive: true,
        ajax: {
            url:$('#myTable').attr("data-url"),
            type:'POST',
            data: function(d) {
                d._token = _token;
            },
        },
       
        columns: [
            { data: 'costingNo' },
            { data: 'client' },
            { data: 'item' },
            { data: 'quantity' },
            { data: 'pickupprice' },
            { data: 'paymentMode' },
            { data: 'taxCode' },
            { data: 'warehouse' },
            { data: 'truckCategory' },
            { data: 'truckerType' },
            { data: 'deliveryType' },
            { data: 'form' },
            { data: null,
                render: function(data){
                    return '<button type="button" name="view" class="btn btn-primary btn-sm text-center py-0" data-bs-toggle="modal" data-bs-target="#viewTransaction" data-id="'+data.id+'">View</button>';
                }
            },
            { data: null,
                render: function(data){
                    return '<button type="button" class="btn btn-success btn-sm text-center py-0" data-id="'+data.id+'">Print</button>';
                }
            },
        ]
    });

    $('#myTable tbody').on('click', 'button[name=view]', function (e) {
        let data = table.row(e.target.closest('tr')).data();
        console.log(data);
        let listGroup= ''
            listGroup = $('<ul class="list-group list-group-flush" ></ul>');
        for (const [key, value] of Object.entries(data)) {
            if (key.indexOf('_id') === -1 && value !== null && value !== '' && value !== '0.0') {
                let listItem = $('<li class="list-group-item d-flex justify-content-between align-items-center py-2"></li>');
                let keySplit = key.replace(/([A-Z])/g, ' $1').trim();
                let keyParts = keySplit.split(' ');
                let finalKey = keyParts.map((word, index) => index === 0 ? word.toUpperCase() : word.toUpperCase()).join(' ');
                let keyDiv = $('<span class="fw-bold" style="font-size: 12px"></span>').text(finalKey);
                let valueDiv = $('<span style="font-size: 12px"></span>');
                if (typeof value === 'string') {
                    valueDiv.text(value.toUpperCase());
                } else {
                    valueDiv.html(value);
                }
                listItem.append(keyDiv, valueDiv);
                listGroup.append(listItem);

            }
        }
        $("#offcanvasRight .offcanvas-body").html(listGroup);
       $("#offcanvasRight").offcanvas('show');
    });
   })

</script>
@endsection