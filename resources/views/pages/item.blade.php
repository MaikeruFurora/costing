@extends('../layout/app')

@section('content')
<style>
.form-label{
    font-size: 13px;
    margin-bottom: 3px
}
.tr-padding th {
    padding: 1px;
    
}
</style>
    <x-title title="ITEM LIST"></x-title>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-lg-3">
            <form class="" id="PriceIndex" action="{{ route('item.store') }}" autocomplete="off">@csrf
               <div class="card">
                <div class="card-body">
                        <div class="form-group d-none">
                            <label class="form-label">ID</label>
                            <input type="text" class="form-control" name="id" readonly>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Item Code</label>
                            <input type="text" class="form-control" name="itemCode" required>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Item Name</label>
                            <textarea class="form-control"  name="itemName" cols="30" rows="2" required></textarea>
                        </div>
                       <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-2">
                              <label class="form-label">Pickup Price</label>
                             <input type="number" step=".01" class="form-control"  name="pickupPrice" required>
                            </div>
                         </div>
                         <div class="col-sm-6">
                            <div class="mb-2">
                              <label class="form-label">Volume Price</label>
                             <input type="number" step=".01" class="form-control"  name="volumePrice">
                            </div>
                         </div>
                       
                       </div>
                        <div class="row">
                           <div class=" col-lg-6 col-sm-12">
                              <div class="mb-2">
                                <label class="form-label">Warehouse</label>
                                <select name="warehouse_origin_id" class="form-control">
                                    @foreach ($warehouseOrigin as $item)
                                        <option value="{{ $item->id }}">{{  $item->warehouse }}</option>
                                    @endforeach
                                </select>
                              </div>
                            </div>
                            <div class=" col-lg-6 col-sm-12">
                               <div class="mb-2">
                                 <label class="form-label">SKU</label>
                                <input type="text" class="form-control" name="sku" required>
                               </div>
                            </div>
                       </div>
                       <div class="row mb-2">
                            <div class=" col-lg-6 col-sm-12">
                               <div class="mb-2">
                                 <label class="form-label">Brand</label>
                                 <select name="brand" class="form-control" data-url="{{ route('costing.brand') }}"></select>
                               </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-2">
                                    <label class="form-label">Company</label>
                                    <select name="company" class="form-control">
                                        <option value=""></option>
                                        <option value="ARVIN">ARVIN</option>
                                        <option value="RH">RH</option>
                                    </select>
                                </div>
                             </div>
                        </div>
                        <div class="row mb-2">
                            <div class=" col-lg-6 col-sm-12">
                               <div class="mb-2">
                                <label class="form-label">Condition</label>
                                <select name="condition" id="" class="form-control">
                                    <option value=""></option>
                                    <option value="lessThan"> Less than (>)</option>
                                    <option value="lessThanOrEqual"> Less than or equal (>=)</option>
                                    <option value="greaterThan"> Greater than (<)</option>
                                    <option value="greaterThanOrEqual"> Greater than or equal (<=)</option>
                                </select>
                               </div>
                            </div>
                            <div class=" col-lg-6 col-sm-12">
                                <div class="mb-2">
                                    <label class="form-label">Quantity</label>
                                    <input type="text" class="form-control not-allowed" name="quantity" readonly>
                                </div>
                            </div>
                        </div>
                       <div class="row">
                            <div class=" col-lg-6 col-sm-12">
                                <div class="mb-2">
                                    <label class="form-label">Action</label>
                                    <select name="status" class="form-control" >
                                        <option value="add">ADD ITEM</option>
                                        <option value="update">UPDATE</option>
                                    </select>
                                </div>
                            </div>
                            <div class=" col-lg-6 col-sm-12">
                                <div class="mb-2">
                                    <label class="form-label">Tax Code</label>
                                    <select class="form-control " name="taxCode">
                                        <option value=""></option>
                                        <option value="OVAT-C">OVAT-C</option>
                                        <option value="OVAT-E">OVAT-E</option>
                                    </select>
                                </div>
                            </div>
                       </div>
                    </div>
                    <div class="card-footer py-2">
                        <button type="submit" class="btn btn-primary" name="">Submit</button>
                        <button type="reset" class="btn btn-warning" name="">Reset</button>
                    </div>
                </div>
            </form>
            </div>
               <div class="col-lg-9">
               <div class="card">
                <div class="card-body">
                   
                    <table id="myTable"  data-url="{{ route('api_priceindex') }}"  class="table table-bordered table-hover" style="width:100%;font-size: 10px;vertical-align: middle;">
                      <thead class="sub-header text-center">
                             <tr>
                                 <th width="7%">
                                    <select name="company_filter" id="" class="form-control form-control-sm" style="font-size:10px;font-weight:600">
                                        <option value="">COMPANY</option>
                                        <option value="ARVIN">ARVIN</option>
                                        <option value="RH">RH</option>
                                    </select> 
                                 </th>
                                 <th>ItemCode</th>
                                 <th>ItemName</th>
                                 <th>Pickup Price</th>
                                 <th>Volume Price</th>
                                 <th>SKU</th>
                                 <th>
                                    <select name="warehouse_filter" id="" class="form-control form-control-sm" style="font-size:10px;font-weight:600">
                                        <option value="">WAREHOUSE</option>
                                        @foreach ($warehouseOrigin as $item)
                                            @if ($item->id != null)
                                                <option value="{{ $item->id }}">{{  $item->warehouse }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                 </th>
                                 <th>
                                    <select name="condition_filter" id="" class="form-control form-control-sm" style="font-size:10px;font-weight:600">
                                        <option value="">CONDITION</option>
                                        <option value="lessThan"> Less than (<)</option>
                                        <option value="lessThanOrEqual"> Less than or equal (<=)</option>
                                        <option value="greaterThan"> Greater than (>)</option>
                                        <option value="greaterThanOrEqual"> Greater than or equal (>=)</option>
                                    </select>
                                 </th>
                                 <th>Quantity</th>
                                 <th>Brand</th>
                                 <th>
                                    <select name="taxcode_filter" id="" class="form-control form-control-sm" style="font-size:10px;font-weight:600">
                                        <option value="">TAXCODE</option>
                                        <option value="OVAT-C">OVAT-C</option>
                                        <option value="OVAT-E">OVAT-E</option>
                                    </select> 
                                 </th>
                             </tr>
                            
                         </thead>
                         <tbody style=" cursor: pointer;"> </tbody>
                 </table>
                </div>
                </div>
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
<!-- Libs JS -->
<script src="./dist/libs/list.js/dist/list.min.js"></script>
<script>

 $(function(){
    let table;
    $('#PriceIndex').on('submit', function(e){
        e.preventDefault();
        let condition = $("select[name=condition]").val();
        let quantity  = $("select[name=quantity]").val();
        let formData  = new FormData(this);
        if (condition!="") {
            if (quantity!="") {
                submitForm(formData);
            }else{
                alert('Please enter quantity');
            }
                    
        }else{
            submitForm(formData);
        }
       
       
    });

    const submitForm = (formData) => {
        $.ajax({
                type: "POST",
                url: $('#PriceIndex').attr("action"),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    $('#myTable').DataTable().ajax.reload();

                    if (data.status) {
                        // alertify.alert('Message',data.msg,false).set('movable', false); 
                        $('#PriceIndex').trigger("reset"); 
                    }else{
                        alertify.alert('Message',data.msg,false).set('movable', false); 
                    }
                },
                error:function(a,b,c){
                    console.log(a.responseText);
                }
        });
    }

   setTimeout(() => {
         table = $("#myTable").DataTable({
            initComplete: function(settings, json) {
                $('.dataTables_scrollBody thead tr').css({visibility:'collapse'});
            },
            processing: true,
            serverSide: true,
            orderable: false,
            ajax: {
                url: $("#myTable").data("url"),
                method: "GET",
                data: function(data){
                    let company     = $('#myTable').find("select[name=company_filter]").val()
                    let warehouse   = $('#myTable').find("select[name=warehouse_filter]").val()
                    let taxcode     = $('#myTable').find("select[name=taxcode_filter]").val()
                    let condition   = $('#myTable').find("select[name=condition_filter]").val()

                    data.company    = company;
                    data.warehouse  = warehouse;
                    data.taxcode    = taxcode;
                    data.taxcode    = taxcode;
                    data.condition  = condition;
                },
            },
            columns: [
                { data: 'company' },
                { data: 'itemCode' },
                { data: 'itemName' },
                { data: 'pickupPrice' },
                { data: 'volumePrice' },
                { data: 'sku' },
                { data: 'warehouse',
                    render:function(data){
                        return data == null ? 'ALL' : data;        
                    }
                },
                { data: 'condition',
                    render:function(data){
                        switch (data) {
                            case 'lessThan':
                                return 'Less than (<) ';
                            break;
                            case 'lessThanOrEqual':
                                return 'Less than or equal(<=) ';
                            break;
                            case 'greaterThan':
                                return 'Greater than (>) ';
                            break;
                            case 'greaterThanOrEqual':
                                return 'Greater than or equal(>=) ';
                            break;
                            default:
                                return ''
                                break;
                        }
                    }
                },
                { data: 'quantity' },
                { data: 'brand' },
                { data: 'taxCode' },
                { visible: false, data: 'warehouse_origin_id' }
            ]
        });
   }, 1000);

    $('select[name=company_filter], select[name=warehouse_filter], select[name=taxcode_filter], select[name=condition_filter]').on('change',function(){
         table.draw();
    });

    $('select[name=items]').select2({
        tags:true,
        ajax: {
            url: '{{ route('api_items') }}',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.itemname,
                            id: item.itemname,
                        }
                    })
                };
            },
            cache: true
        }
    });

    $('#myTable tbody').on('dblclick', 'tr', function () {
        // Set the value of the 'status' select element to 'update'
        // Select the option with value 'update' in the 'status' select element
        var obj = table.row(this).data();
        
        $.each($("#PriceIndex .form-control"),function(index,element){
            let fieldName = element.name;
            let fieldValue = obj[fieldName];
            if(fieldName === 'itemCode'){
                brand(fieldValue);
                $(element).val(fieldValue);
            }else if (fieldName === "") {
                $("input[name=quantity]").prop('readonly',!fieldValue.length !="").addClass('not-allowed');
            }else{
                $(element).val(fieldValue);
            }
        });
        
        setTimeout(function(){
            $("select[name=brand]").val(obj['brand'])
        },1000);
        $("select[name=status]").val('update');//.find("option[value='update']").prop('selected', true);
    });
 })

 $("[name=itemCode]").on("blur",function(){
    let url        = $(this).attr("data-url");
    let itemcode   = $(this).val()
    brand(itemcode)
 })

 $("select[name=condition]").on("change",function(){
    $("input[name=quantity]").prop('readonly',!$(this).val().length !="").addClass('not-allowed');
 })

 $("[type=reset]").on("click",function(){
    $("[name=brand]").empty()
 })

 const brand = (itemcode) =>{
    let select     = $("[name=brand]");
    $.ajax({
        type: "GET",
        url: $("[name=brand]").attr("data-url"),
        data:{
            itemcode
        },
        success: function (data) {
            select.empty().append(new Option('',''));
            $.each(data,function(i,val){
                select.append(new Option(val.brand,val.brand))
            })
        },
        error: function (msg) {
            $('#PriceIndex').find("[name=brand]").val('');
        }
    });
 }

</script>
@endsection
