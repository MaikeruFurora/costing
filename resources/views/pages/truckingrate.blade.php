@extends('../layout/app', ['title' => 'Adjustment'])

@section('content')
<x-title title="TRUCKING RATE"></x-title>
<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
        <form class="" id="TruckRateForm" action="{{ route('truckmatrix_store') }}" autocomplete="off">@csrf
            <div class="card">
                <div class="card-body">
                        <div class="mb-2 d-none">
                            <label class="form-label">ID</label>
                            <input type="text" class="form-control " name="id"  readonly>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Warehouse Origin</label>
                            <select class="form-control form-control " name="warehouse_origin_id" required>
                                <option value=""></option>
                                @foreach ($warehouseOrigin as $item)
                                    <option value="{{ $item->id }}">{{ $item->warehouse }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Province</label>
                                    <select class="form-control form-control " name="province"  data-url="{{ asset('location/refprovince.json') }}" required>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label>Municipality</label>
                                    <select class="form-control form-control " name="municipality" data-url="{{ asset('location/refcitymun.json') }}" required>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        
                        </div>
                        <div class="mb-2">
                            <div class="col-lg-12">
                                <label>Group Area</label>
                                    <div class="row g-2">
                                      <div class="col">
                                         <select class="form-control " name="grouparea_id"
                                            data-list = "{{ route('grouparea.list') }}"   
                                            data-store = "{{ route('grouparea.store') }}" 
                                            style="text-transform: uppercase"  
                                         >
                                            <option value=""></option>
                                            @foreach ($groupArea as $item)
                                                <option value="{{ $item->id }}">{{ $item->area }}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                    <div class="col-auto">
                                    <button class="btn btn-icon" type="button" name="addCategory">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Truck Type</label>
                                <select class="form-control form-control " name="trucktype_id" required>
                                    @foreach ($trucktype as $item)
                                        <option value="{{ $item->id }}">{{ $item->trucktype }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Rate</label>
                                <input type="number" class="form-control" name="rate" step=".01" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <label>Active</label>
                                <select class="form-control " name="active" required>
                                    <option value="Y">Yes</option>
                                    <option value="N">No</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <label>Action</label>
                                <select class="form-control" name="status" required>
                                    <option value="add">ADD</option>
                                    <option value="update">UPDATE</option>
                                </select>
                            </div>
                        </div>
                        <br>
                </div>
                <div class="card-footer py-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-warning" >Clear</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-xl-9 col-lg-6 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header py-2">
                <button class="btn btn-primary btn-sm float-end">Update Rate</button>
            </div>
        <div class="card-body">
            <table class="table table-bordered table-hover" id="myTable" style="width:100%;font-size: 10px;vertical-align: middle;" data-url="{{ route('api_showtruckrate') }}">
                <thead class="sub-header">
                    <tr>
                        <th scope="col" width="10%">
                            <select class="form-control form-control-sm" name="warehouse_filter" required style="font-size:10px;font-weight:600">
                                <option value="">WAREHOUSE</option>
                                @foreach ($warehouseOrigin as $item)
                                    <option value="{{ $item->id }}">{{ $item->warehouse }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col" >&nbsp;&nbsp;Province</th>
                        <th scope="col">&nbsp;&nbsp;Municipality</th>
                        <th scope="col">
                            <select class="form-control form-control-sm" name="trucktype_filter" required style="font-size:10px;font-weight:600">
                                <option value="">-TRUCKTYPE-</option>
                                @foreach ($trucktype as $item)
                                    <option value="{{ $item->id }}">{{ $item->trucktype }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col">&nbsp;&nbsp;Rate</th>
                        <th scope="col">
                            <select class="form-control form-control-sm" name="group_area_filter" required style="font-size:10px;font-weight:600">
                                <option value="">GROUP AREA</option>
                               @foreach ($groupArea as $item)
                                   <option value="{{ $item->id }}">{{ $item->area }}</option>
                               @endforeach
                            </select>
                        </th>
                        <th scope="col" width="7%">
                            <select class="form-control form-control-sm" name="active" required style="font-size:10px;font-weight:600">
                                <option>-ACTIVE-</option>
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select>
                        </th>
                    </tr>
                </thead>
                <tbody style=" cursor: pointer;"></tbody>
                
            </table>
        </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/datatable/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('assets/datatable/js/responsive.bootstrap5.js') }}"></script>
<script>

       $(function(){
        let myTable = $("#myTable")
        let urlData = myTable.data("url");
        let table
        $('#TruckRateForm').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            formData.append('province', $("[name=province] :selected").text());
            formData.append('municipality', $("[name=municipality] :selected").text());
            $.ajax({
                type: "POST",
                url:  $('#TruckRateForm').attr("action"),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('province', $('select[name=province]').val());
                },
                success: function(msg) {
                    $('#TruckRateForm')[0].reset()
                    $('select[name=province]').val(null).trigger('change');
                    $('select[name=municipality]').empty();
                    alertify.success("You've clicked saved");
                    $('#myTable').DataTable().ajax.reload();
                }
            });
            $('#TruckRateForm').trigger("reset");
        });

       Core.provinceData()
        
        $('select[name=province]').on('select2:select', function (e) {
            let code = e.params.data.id
            Core.municipalityData(code)
        });

      setTimeout(() => {
        table = myTable.DataTable({
            initComplete: function () {
                this.api().columns().every(function () {
                    let column = this;
                    let select = $('<select><option value=""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), true, false, true).draw();
                        });
                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>');
                    });
                });
            },
            serverSide: true,
            orderable: false,
            ajax: {
                url: urlData,
                method: "get",
                data: function(data){

                    let trucktype   = $('#myTable').find("select[name=trucktype_filter]").val()
                    let warehouse   = $('#myTable').find("select[name=warehouse_filter]").val()
                    let active      = $('#myTable').find("select[name=active_filter]").val()
                    let group_area  = $('#myTable').find("select[name=group_area_filter]").val()
                    data.trucktype  = trucktype;
                    data.warehouse  = warehouse;
                    data.active     = active;
                    data.group_area = group_area;
                },
            },
            columns: [
                { data: "warehouse" },
                { data: "province" },
                { data: "municipality" },
                { data: "trucktype" },
                { data: "rate", },
                { data: "area" },
                {
                    data: "active",
                    render: function (data) {
                        return data == 'Y' ? 'YES' : 'NO';
                    }
                },
                { data: "trucktype_id", visible: false },
                { data: "id", visible: false }
            ]
        });
      }, 1000);

    $('select[name=trucktype_filter], select[name=warehouse_filter], select[name=active_filter], select[name=group_area_filter]').on('change',function(){
         table.draw();
    });

        $('#myTable tbody').on('dblclick', 'tr', function () {
            Core.provinceData()
            var obj = table.row(this).data();
            $('[name=id]').val(obj['id']);
            $('[name=trucktype_id]').val(obj['trucktype_id']);
            $('[name=grouparea_id]').val(obj['grouparea_id']);
            $('[name=rate]').val(obj['rate']);
            $('[name=active]').val(obj['active']);
            $('select[name=warehouse_origin_id]').val(obj['warehouse_id']);
            $('select[name=province]').find('option:contains("' + obj['province'] + '")').eq(0).prop('selected', true);
            Core.municipalityData($('select[name=province]').val())
            setTimeout(() => {
                $('select[name=municipality]').val(obj['municipality']).trigger('change');
            }, 1000);
            $("select[name=status]").val('update');
        });

        $("button[type=reset]").on("click",function(){
            Core.provinceData()
            $('select[name=province]').empty().trigger('change');
            $('select[name=municipality]').empty().trigger('change');
            $.each($("#TruckRateForm .form-control"),function(i,val){
                $('select[name='+val.name+']').val(null).trigger('change');
            });
        })
    })


    $("select[name=grouparea_id]").select2({
        placeholder:'Select Group area',
        tags:true,
        ajax: {
            url: $('select[name=grouparea_id]').attr("data-list"),
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: item.area,
                            id: item.id,
                        }
                    })
                };
            },
            cache: true
        }
    })


    $("button[name=addCategory]").on('click',function(e){
        e.preventDefault()
        let element = $('select[name=grouparea_id]');
        let new_category = $.trim(element.val());
        if(new_category != ''){
            $.ajax({
                url:element.attr("data-store"),
                method:"POST",
                data:{
                    _token: Core.token,
                    area: new_category
                },
                success:function(data){
                    if(data.msg == 'Created'){
                        element.val(null).trigger('change');
                        // Then, add the new option and set it as selected
                        let option = new Option(data.data.area, data.data.id, true, true);
                        element.append(option).trigger('change');
                    }
                }
            })
        }else{
            alert('Please select group area');
        }
    })
</script>
@endsection