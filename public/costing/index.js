const dataCosting = [];
let dataCostingNo = [];
const CostingData = {
    msgTruckingRate:function(){
        let capacity        = CostingForm.find("select[name=trucktype_id] :selected").attr("data-capacity");
        if (capacity==0) {
            CostingForm.find(".text-msg").text("")
            CostingForm.find("[name=trucking]").val(0).prop("readonly",false)
        }else{
            CostingForm.find("[name=trucking]").val(0).prop("readonly",true)
            CostingForm.find(".text-msg").text((CostingForm.find("[name=item]").val()==null)? "Please select an item to calculate rate" : "")
        }
    },
    costingSum:function(){
        let sum = 0;
        $('.group-sum').each(function() {
            let value = parseFloat($(this).val());
            if (!isNaN(value)) {
                sum += value;
            }
        });
        let subTotal = sum;
        $('input[name="grossprice"]').val(isNaN(sum) ? 0 : sum);
    },
    getPriceIndex:function(_token,warehouse,item,brand){
        $.ajax({
            url: CostingForm.find("[name='pickupprice']").attr("data-url"),
            type: 'GET',
            data: {
                _token,warehouse,item,brand
            },
            dataType: 'json',
            success: function (data) {
                CostingForm.find("[name='pickupprice']").val(data.pickupprice ? data.pickupprice : 0);
                CostingData.costingSum()
            },
            error:function(data){
                CostingForm.find("[name='pickupprice']").val(0);
                CostingData.costingSum()
            }
        });
    },
    formSubmit:function(formData){
        $.ajax({
            type: "POST",
            url: CostingForm.attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function (msg) {
                CostingForm.find(".form-control").val(0);
                CostingForm.find("[name=brand]").val('');
                CostingForm.find("[name=client]").empty()
                CostingForm.find("[name=item]").empty()
                CostingForm.find("[name=province]").empty()
                CostingForm.find("[name=municipality]").empty()
                dataCostingNo = [];
            },
            error: function (msg) {
                alert("Please check your input")
            }
        });
    },
    brandList:function(itemcode){
        let select = CostingForm.find("[name=brand]");
        $.ajax({
            type: "GET",
            url: select.attr("data-url"),
            data:{
                itemcode
            },
            success: function (data) {
                select.empty();
                $.each(data,function(i,val){
                    select.append(new Option(val.brand,val.brand))
                })
            },
            error: function (msg) {
                CostingForm.find("[name=brand]").val('');
            }
        });
    }
}


    $('.form-control').keydown(function(e){
            if (e.keyCode == 13) { // If Enter key is pressed
            e.preventDefault(); // Prevent default enter behavior
            var inputs = $('input'); // Get all input fields
            var nextIndex = inputs.index(this) + 1; // Calculate index of next input field
            if (nextIndex < inputs.length) {
                inputs[nextIndex].focus().select(); // Move focus to next input field
            }
            }
    });

    $('[name=quantity]').number( true, 3 );
    $('.group-sum').number( true, 3 );
    $('[name=grossprice]').number( true, 3 );
    let   TruckerRateForm = $('#TruckerRateForm')
    let   CostingForm     = $('#costingForm')
    
    CostingForm.on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let capacity = CostingForm.find("[name=trucktype_id] :selected").attr("data-capacity"); // Get the selected option element
        let quantity = CostingForm.find("[name=quantity]").val();
        let sku      = CostingForm.find("[name=sku]").val();
        let bool     = Core.checkTruckLoad(capacity,sku,quantity);
        formData.append('item', CostingForm.find("[name=item] :selected").text());
        formData.append('client', CostingForm.find("[name=client] :selected").val());
        formData.append('itemCode', CostingForm.find("[name=item]").val());
        formData.append('_token', Core.token);
      
        if (bool && Object.prototype.hasOwnProperty.call(bool, 'msg')) {
            alertify.confirm(bool.msg, function (e) {
                if (e) {
                    CostingData.formSubmit(formData);
                    formData.append('confirmation', 'YES');
                    alertify.confirm().set({
                        labels : {
                            ok     : 'Confirm',
                            cancel : 'Cancel',
                        },
                    });
                    alertify.success("You've clicked saved");
                } else {
                    alertify.confirm().set({
                        labels : {
                            ok     : 'Confirm',
                            cancel : 'Cancel',
                        },
                    });
                    alertify.error("You've clicked Cancel");
                }
            });
        }else{
            CostingData.formSubmit(formData);
        }
           
              
    });

    $('.group-sum').on('change keyup blur', function() {
        CostingData.costingSum()
    });
    
    $('select[name=warehouse_origin_id], select[name=item]').on('change', function (e) {
        e.stopPropagation();
        let   warehouse = CostingForm.find("[name=warehouse_origin_id]").val();
        let   item      = CostingForm.find("select[name=item]").val();
        let   brand     = CostingForm.find("select[name=item]").select2('data')[0].brand;
                          TruckerRateForm.find("[name=sku]").val(CostingForm.find("select[name=item]").select2('data')[0].sku);
                          CostingData.getPriceIndex(Core.token,warehouse,item,brand)
    });

    $('select[name=item]').select2({
        tags:true,
        allowClear:true,
        placeholder: 'Select an item',
        ajax: {
            url: $('select[name=item]').attr("data-url"),
            dataType: 'json',
            processResults: function (data) {
                let results = $.map(data, function (item) {
                    return {
                        text: item.itemname,
                        id: item.itemcode, //+'^'+parseFloat(item.sweight1)+'^'+item.brand+'^'+item.taxcode,
                        sku: parseFloat(item.sweight1),
                        taxcode: item.taxcode,
                        brand: item.brand,
                    }
                });
                return {
                    results: results
                };
            },
            cache: true
        }
    }).on('select2:unselect', function (e) {
        let select = $(this);
        let data = e.params.data;
        if (data) {
            select.append(new Option(data.text, data.id, true, true));
        }
    }).on('select2:select', function (e) {
        let select = $(this);
        let data = e.params.data;
        if (!data || data.id === '') {
            select.val('').trigger('change');
        }
    }).on('select2:unselecting', function (e) {
        let selection = $(this).select2('data');
        if (selection.length > 0) {
            e.preventDefault();
        }
        e.stopPropagation();
        setTimeout(() => {
            $("[name='pickupprice']").val(0);
            CostingData.costingSum()
            CostingForm.find("[name=brand]").val('');
            CostingForm.find("[name=sku]").val('');
            CostingData.msgTruckingRate()
        }, 1000);
    }).on('change',function(){
        console.log($(this).select2('data')[0].id);
        CostingData.brandList($(this).val());
        CostingForm.find("[name=brand]").val($(this).select2('data')[0].brand);
        CostingForm.find("[name=sku]").val($(this).select2('data')[0].sku);
    });


    $('#myTable tbody').on('click', 'tr', function () {
        var obj = table.row(this).data();
        // console.log(obj);
        $.each($("#itemadd .form-control"), function (i, val) {
            $('input[id=' + val.id + ']').val(obj[val.id])
        });
    });

    $('select[name=client]').select2({
        tags: true,
        ajax: {
            url: $('select[name=client]').attr("data-url"),
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.cardname,
                            id: item.cardname,
                            cardcode: item.cardcode,
                        }
                    })
                };
            },
            cache: true
        }
    });


CostingForm.find("[name=specialPrice]").on('change',function(){
    CostingForm.find("[name=pickupprice]").prop("readonly",!($(this).val()==="YES"));
    if ($(this).val()=="NO") {
        let   warehouse = CostingForm.find("[name=warehouse_origin_id]").val();
        let   item      = CostingForm.find("select[name=item]").val();
        let   brand     = CostingForm.find("select[name=item]").select2('data')[0].brand;
        console.log(warehouse,item,brand);
                        TruckerRateForm.find("[name=sku]").val(CostingForm.find("select[name=item]").select2('data')[0].sku);
                        CostingData.getPriceIndex(Core.token,warehouse,item,brand)
    }else{
        CostingForm.find("[name=pickupprice]").val(0);
    }
    CostingData.costingSum()
})

$('select[name=province]').select2({
    // tags:true,
    minimumResultsForSearch: Infinity, // Disable search
    ajax: {
        url: 'https://psgc.gitlab.io/api/provinces/',
        dataType: 'json',
        processResults: function (data) {
            TruckerRateForm.find("select[name=municipality]").empty();
            data.sort((a, b) => a.name.localeCompare(b.name));
            return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.code+'^'+item.name,
                    }
                })
            };
        },
        cache: true
    }
})

$('select[name=province]').on('select2:select', function (e) {
    let code = e.params.data.id.split('^')[0];
    $('select[name=municipality]').select2({
    minimumResultsForSearch: Infinity, // Disable search
        tags: false,
        ajax: {
            url: `https://psgc.gitlab.io/api/provinces/${code}/cities-municipalities/`,
            dataType: 'json',
            processResults: function (data) {
                data.sort((a, b) => a.name.localeCompare(b.name));
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.name,
                        }
                    })
                };
            },
            cache: false
        }
    })
});


/**
 * 
 * TRUCKING RATE MATRIX
 * 
 */
   
$('select[name=warehouse_origin_id], select[name=province], select[name=municipality], select[name=trucktype_id], select[name=item] , input[name=quantity]').on('change keyup', function () {
    let itemSelected = CostingForm.find("select[name=item]").find(':selected').length > 0;
    let capacity        = CostingForm.find("select[name=trucktype_id] :selected").attr("data-capacity");
    if (itemSelected) {
        let warehouse       = CostingForm.find("select[name=warehouse_origin_id]").val();
        let province        = CostingForm.find("select[name=province] :selected").text();
        let municipality    = CostingForm.find("select[name=municipality] :selected").text();
        let trucktype       = CostingForm.find("select[name=trucktype_id]").val();
        let quantity        = CostingForm.find("[name=quantity]").val();
        let sku             = CostingForm.find("select[name=item]").select2('data')[0].sku
        CostingData.msgTruckingRate()
        $.ajax({
            url:  CostingForm.find("[name=trucking]").attr("data-url"),
            type: "POST",
            data: {
                _token: Core.token,warehouse,province,municipality,trucktype
            },
            datajson: true,
            success: function (data) {
                let finalRate = isNaN(Core.finalRate(sku,data.rate,capacity,quantity))? '' : Core.finalRate(sku,data.rate,capacity,quantity);
                console.log(finalRate);
                CostingForm.find("[name=trucking]").val(finalRate);
                // $("[name=trucking]").val(finalRate);
                CostingData.costingSum()
            },
            error:function(data){
                CostingData.costingSum()
            }
        });
    } else {
        CostingData.msgTruckingRate()
    }
    
});

CostingForm.find("[name=trucktype_id]").on('change', function () {
    let selectedOption = $(this).find(':selected');
    let capacity = selectedOption.attr("data-capacity");
    if(capacity==0){
        CostingForm.find("[name=deliveryType]").val('PICK-UP')
    }else{
        CostingForm.find("[name=deliveryType]")
            .find('option:first')
            .prop('selected', true);
    }

})

let previousTransactionTable;

$("#prevTransaction").on('click', function() {
    
    let client = CostingForm.find("select[name=client]").val();
    let itemCode = CostingForm.find("select[name=item]").val();
    let _token = Core.token;
    
    if (previousTransactionTable) {
        previousTransactionTable.destroy();
    }
    
    previousTransactionTable = $('#previousTransactionTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: $('#previousTransactionTable').data('url'),
            type: 'GET',
            data: function(d) {
                d._token = _token;
                d.client = client;
                d.itemCode = itemCode;
            },
        },
        columns: [
            { data: null, render: function(data, type, row, meta) {
                return `<input type="checkbox" class="form-check-input" value="${data.costingNo}">`;
            }},
            { data: 'costingNo' },
            { data: 'warehouse' },
            { data: 'client' },
            { data: 'item' },
            { data: 'quantity' },
            { data: 'pickupprice'  }
        ],
        columnDefs: [
            { targets: 'hidden', visible: false },
        ],
    });
    
    $("#viewTransaction").modal("show");
});

$(document).on('change', '#previousTransactionTable input[type="checkbox"]', function() {
    //uncheck other checkboxes
    $('#previousTransactionTable input[type="checkbox"]:checked').not(this).prop('checked',false);

    if ($(this).is(":checked")) {
        let conditions = ['item','client']
        let obj = previousTransactionTable.row($(this).closest("tr")).data();
        CostingData.brandList(obj['itemCode']);
       setTimeout(() => {
        $.each(obj,function(i,val){
            if (!conditions.includes(i)) {
                CostingForm.find('input[name='+i+']').val(val)
                CostingForm.find('select[name='+i+']').val(val)
            }
        }); 
       },1000)
        $('[name=province]').empty().append(new Option(obj['province']));
        $('[name=municipality]').empty().append(new Option(obj['municipality']));
    } else {
        CostingForm.find('input').val('')
        CostingForm.find('select').val('')
        $('[name=province]').empty()
        $('[name=municipality]').empty()
    }
})
