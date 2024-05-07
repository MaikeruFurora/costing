
$('[name=quantity]').number( true, 5 );
$('.group-sum').number( true, 5 );
$('[name=grossprice]').number( true, 5 );
const CostingForm      = $("#CostingForm");
const rowCosting       = []
const previousTrucking = []; 
const rowCoload        = []; 
let tempCosting        = {};
const CostingData = {
    msgTruckingRate:function(){
        let capacity        = CostingForm.find("select[name=trucktype_id] :selected").attr("data-capacity");
        if (capacity===0) {
            CostingForm.find(".text-msg").text("")
            CostingForm.find("[name=trucking]").val(0).prop("readonly")
        }else{
            CostingForm.find("[name=trucking]").val(0).prop("readonly",true)
            // CostingForm.find(".text-msg").text((CostingForm.find("[name=itemName]").val()==null)? "Please select an item to calculate rate" : "")
        }
    },
    costingSum:function(){
        let sum = 0;
        $('.group-sum').each(function() {
            let vale = parseFloat($(this).val());
            if (!isNaN(value)) {
                sum += value;
            }
        });
        let subTotal = sum;
        $('input[name="grossprice"]').val(isNaN(sum) ? 0 : sum);
    },
    getPriceIndex:function(dataRequest){
        $.ajax({
            url: CostingForm.find("[name='pickupPrice']").attr("data-url"),
            type: 'GET',
            data: dataRequest,
            dataType: 'json',
            success: function (data) {
                CostingForm.find("[name='pickupPrice']").val(data.pickupPrice ? data.pickupPrice : 0);
                totalGrossPrice()
            },
            error:function(data){
                CostingForm.find("[name='pickupPrice']").val(0);
                totalGrossPrice()
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
                CostingForm.find("[name=brand]").empty();
                CostingForm.find("[name=client]").empty()
                CostingForm.find("[name=itemName]").empty()
                CostingForm.find("[name=addRow]").text('Add')
                $('select[name=province]').empty().trigger('change');
                $('select[name=municipality]').empty().trigger('change');
                CostingForm.find(".itemCode").text('');
                Core.provinceData()
                rowCosting.splice(0, rowCosting.length);
                displayTable()
                tempCosting= {}
                alertify.alert('Message',"Costing submitted successfully");
            },
            error: function (a,b,c) {
                alert(a.responseText,b,c)
            }
        });
    },
   
    inputFields:function(){
        return [
            {
                label:'Item Description', name:'itemName', value:'', tag:'table',
            },
            {
                label:'Quantity', name:'quantity', value:0, tag:'table',
            },
            {
                label:'Tax Code', name:'taxCode', value:'', tag:'table',
            },
            {
                label:'Scpecial Price', name:'specialPrice', value:0, tag:'table',
            },
            {
                label:'Pickup Price', name:'pickupPrice', value:0, tag:'table',
            },
            {
                label:'Brand', name:'brand', value:'', tag:'table',
            },

            {
                label:'Analysis Fee', name:'analysisFee', value:0, tag:'offcanvas'
            },
            {
                label:'Plastic Liner', name:'plasticLiner', value:0, tag:'offcanvas'
            },
            {
                label:'Two Drops', name:'twoDrops', value:0, tag:'offcanvas'
            },
            {
                label:'Parking', name:'parking', value:0, tag:'offcanvas'
            },
            {
                label:'Additional Trucking', name:'additionalTrucking', value:0, tag:'offcanvas'
            },
            {
                label:'Ttoll Fee', name:'tollFee', value:0, tag:'offcanvas'
            },
            {
                label:'Allowance', name:'allowance', value:0, tag:'offcanvas'
            },
            {
                label:'Loading', name:'loading', value:0, tag:'offcanvas'
            },
            {
                label:'Unloading', name:'unloading', value:0, tag:'offcanvas'
            },
            {
                label:'Additional Unloading', name:'additionalUnloading', value:0, tag:'offcanvas'
            },
            {
                label:'terms', name:'terms', value:0, tag:'offcanvas'
            },
            {
                label:'Cleaning', name:'cleaning', value:0, tag:'offcanvas'
            },
            {
                label:'Entry Fee', name:'entryFee', value:0, tag:'offcanvas'
            },
            {
                label:'Empty Sack', name:'emptySack', value:0, tag:'offcanvas'
            },
            {
                label:'Sticker', name:'sticker', value:0, tag:'offcanvas'
            },
            {
                label:'Escort', name:'escort', value:0, tag:'offcanvas'
            },
            {
                label:'Bank Charge', name:'bankCharge', value:0, tag:'offcanvas'
            },
            {
                label:'Commision', name:'commision', value:0, tag:'offcanvas'
            },
            {
                label:'Service Fee', name:'serviceFee', value:0, tag:'offcanvas'
            },
            {
                label:'Allowance Weight', name:'allowanceWeight', value:0, tag:'offcanvas'
            },
            {
                label:'Truck Scale', name:'truckScale', value:0, tag:'offcanvas'
            },
            {
                label:'Others', name:'others', value:0, tag:'offcanvas'
            },
        ]
    },
    checkTruckLoad:function(capacity,deliveryType){
        let inkls = rowCosting.reduce((acc, row) => acc + (parseInt(row.quantity * row.sku)), 0);
        console.log(inkls);
        if (inkls < parseFloat(capacity) && deliveryType=="ONETIMEDELIVERY") {
            return {
                msg: "The truck is underload. Would you like to continue?"+inkls,
                status: false
            }
        } else if (inkls > parseFloat(capacity) && deliveryType=="ONETIMEDELIVERY") {
            return {
                msg: "Truck is over load",
                status: false
            }
        } else {
            return {
                status: true
            }
        }
    },

    getTruckingRate: function(warehouse, province, municipality, trucktype) {
        $.ajax({
            url: CostingForm.find("[name=trucking]").attr("data-url"),
            type: "POST",
            data: {
                _token: Core.token,
                warehouse,
                province,
                municipality,
                trucktype
            },
            dataType: "json",
            success: function(data) {
                CostingForm.find("[name=rate]").val(data.rate);

            },
            error: function(data) {
                CostingForm.find("[name=rate]").val(null);
                totalGrossPrice()
            }
        });
    },
    getTruckingRateVersion2: async function(warehouseId, provinceId, municipalityId, truckTypeId) {
        try {
            const response = await $.ajax({
                url: CostingForm.find("[name=trucking]").attr("data-url"),
                type: "POST",
                data: {
                    _token: Core.token,
                    warehouseId,
                    provinceId,
                    municipalityId,
                    truckTypeId
                },
                dataType: "json"
            });
            return response.rate;
        } catch (error) {
            CostingData.costingSum();
            throw error;
        }
    },
    itemList:function(){
        return {
            url:$('select[name=itemName]').attr("data-url"),
            dataType: 'json',
            processResults: function (data) {
                let results = $.map(data, function (item) {
                    return {
                        text: item.itemname,
                        id: item.itemcode,
                        sku: parseFloat(item.sweight1),
                        taxcode: item.taxcode,
                    }
                });
                return {
                    results: results
                };
            },
            cache: true
        }
    },
    isEmptyOrZero:function(...values) {
        return values.every(val => {
            return !(val === "" || val === 0 || val === null || val === undefined);
        });
    },

    getRecomputedTruckingRate: function() {
        $.ajax({
            url: CostingForm.find("[name=trucking]").attr("data-url"),
            type: "POST",
            data: {
                _token: Core.token,
                warehouse,
                province,
                municipality,
                trucktype
            },
            dataType: "json",
            success: function(data) {
                CostingForm.find("[name=rate]").val(data.rate);

            },
            error: function(data) {
                CostingForm.find("[name=rate]").val(null);
                totalGrossPrice()
            }
        });
    }
    
}

/**
 * 
 * SEARCH ITEM DESCRIPTION
 * 
 */


$('select[name=itemName]').select2({
    placeholder: 'Select an item',
    ajax:CostingData.itemList()
}).on('change',function(){
    Core.brandList($(this).select2('data')[0].id);
    CostingForm.find("[name=sku]").val($(this).select2('data')[0].sku);
    CostingForm.find("[name=itemCode]").val($(this).select2('data')[0].id);
    CostingForm.find(".itemCode").text($(this).select2('data')[0].id);
});


/**
 * 
 * SELECT PROVINCE
 * 
 */

Core.provinceData()

/**
 * 
 * SELECT MUNICIPALITY
 * 
 */


$('select[name=province]').on('select2:select', function (e) {
    let code = e.params.data.id
    Core.municipalityData(code)
});

/***
 * 
 * SELECT CLIENT
 * 
 */

$('select[name=client]').select2({
    placeholder: 'Select a client',
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
})

/***
 * 
 *  IF SPECIAL PRICE IS YES THEN PICKUP PRICE IS READONLY
 * 
 */

CostingForm.find("[name=specialPrice]").on('change',function(){
    if ($(this).val()=="NO") {
                          CostingForm.find("[name=pickupPrice]").prop("readonly",true).addClass('not-allowed').val('');
        let   warehouse = CostingForm.find("[name=warehouse_origin_id]").val();
        let   item      = CostingForm.find("select[name=itemName]").val();
        let   company   = CostingForm.find("select[name=company]").val();
        let   taxCode   = CostingForm.find("select[name=taxCode]").val();
        let   brand     = CostingForm.find("select[name=brand]").val() || CostingForm.find("select[name=brand] option:selected").brand;
                          CostingData.getPriceIndex({
                              warehouse, item, company, taxCode, brand,_token:Core.token
                          })
    }else{
        CostingForm.find("[name=pickupPrice]").prop("readonly",false).removeClass('not-allowed').val(0);
    }
    CostingData.costingSum()
})

/**
 *  
 * MORE COSTING
 * 
 */

CostingForm.find('button[name=more]').on('click',function(){
    CostingForm.find("#offcanvasRight .btn-close").val("open")
    displayMoreCosting(tempCosting,false)
})

/**
 * 
 * DISPLAY MORE COSTING
 * 
 */

const displayMoreCosting = function(dataJson,disabled){
    let listGroup = $("<ul/>",{class:"list-group"});
    let list = CostingData.inputFields().sort((a,b)=>a.name.localeCompare(b.name));
    for(let i = 0; i<list.length; i++){
        if(list[i].tag==="offcanvas"){
            let listItem = $("<li/>",{class:"list-group-item d-flex justify-content-between align-items-center px-2 py-1"});
            let label = $("<label/>",{class:"mr-auto",text:list[i].label});
            let input = $(`<input class='form-control form-control-sm' style='width: 50%;' type='number' step='.01' name="${list[i].name}" ${disabled? 'disabled':''}/>`);
            if(dataJson && dataJson[list[i].name]){
                input.val(dataJson[list[i].name]);
            }
            listItem.append(label).append(input);
            listGroup.append(listItem);
        }
    }
    $("#offcanvasRight .offcanvas-body").empty().append(listGroup);
    $("#offcanvasRight").offcanvas('show');
}

/**
 * 
 * SAVING TEMP COSTING
 * 
 */
CostingForm.find("#offcanvasRight .btn-close").on('click',function(){
    if ($(this).val()=="open") {
    $("#offcanvasRight .list-group-item input").each(function(){
            tempCosting[$(this).attr("name")] = $(this).val();
        })
    }
    totalGrossPrice()
})


/**
 * 
 * DISPLAY MORE ROW COSTING
 * 
 */


$("table.table tbody").on("click", "button[name=moreCostingRow]", function(){
    let id    = $(this).data("id");
    displayMoreCosting(rowCosting[id],true)
    $(".btn-close").val("close")
})

/**
 * 
 *  TOTAL GROSS PRICE
 * 
 */


const totalGrossPrice = () => {
    let totalCosting = 0;
    let trucking = parseFloat(CostingForm.find("[name=trucking]").val());
    let pickupPrice = parseFloat(CostingForm.find("[name=pickupPrice]").val());

    // Avoid Infinity value
    trucking = isFinite(trucking) ? trucking : 0;
    pickupPrice = isFinite(pickupPrice) ? pickupPrice : 0;

    for (let key in tempCosting) {
        if (!isNaN(parseFloat(tempCosting[key]))) {
            totalCosting += parseFloat(tempCosting[key]);
        }
    }

    totalCosting += trucking;
    totalCosting += pickupPrice;

    CostingForm.find("[name=totalCosting]").val(totalCosting.toFixed(5));
        CostingForm.find("[name=totalCosting]").val(totalCosting.toFixed(5));
}

/**
 * 
 * ADD ROW IN TABLE
 * 
 */

CostingForm.find('button[name=addRow]').on('click',function(e){
    // e.stopPropagation()
    $('#myTable.table tbody tr').removeClass('highlighted').find('button').prop("disabled", true);
    let index        = $(this).data("id")
    let item         = CostingForm.find("[name=itemName]").val();
    let quantity     = CostingForm.find("[name=quantity]").val();
    let specialPrice = CostingForm.find("[name=specialPrice]").val();
    let trucking     = CostingForm.find("[name=trucking]").val();
    let itemCode     = CostingForm.find("[name=itemCode]").val();
    let sku          = CostingForm.find("[name=sku]").val();
    let totalCosting = CostingForm.find("[name=totalCosting]").val();
    let pickupPrice  = CostingForm.find("[name=pickupPrice]").val();
    let volumePrice  = CostingForm.find("[name=volumePrice]").val();
    let brand        = CostingForm.find("[name=brand]").val();
    let taxCode      = CostingForm.find("[name=taxCode]").val();
    let inKls        = sku*quantity;
    let itemName     = "";
    let itemData = CostingForm.find("[name=itemName]").select2('data');
    if(itemData !== undefined && itemData.length > 0){
        itemName = itemData[0].text;
    }
    if (item!==null && quantity!=='' && parseInt(quantity)!==0 && pickupPrice!=='' && trucking!=='' && parseFloat(trucking)>0){  
            if (index != "") {
                rowCosting.splice(index, 1);
            }
        
            rowCosting.push({
                itemName,quantity,taxCode,
                trucking,specialPrice,pickupPrice,volumePrice,
                brand,sku,totalCosting,itemCode,inKls, ...tempCosting
            })
            displayTable()
            tempCosting={}
            CostingForm.find('[name=itemName]').empty().val(null).trigger('change.select2')
            CostingForm.find('[name=quantity]').val(0)
            CostingForm.find('[name=specialPrice]').val('')
            CostingForm.find('[name=volumePrice]').val('')
            CostingForm.find('[name=trucking]').val(0)
            CostingForm.find('[name=itemCode]').val('')
            CostingForm.find('[name=sku]').val('')
            CostingForm.find('[name=totalCosting]').val(0)
            CostingForm.find('[name=pickupPrice]').val(0)
            CostingForm.find('[name=brand]').empty()
            CostingForm.find('[name=taxCode]').val('')
            CostingForm.find('[name=itemName]').val('')
            $(this).data('edit','N').data('id','').text('Add Costing').prop('disabled',false)
        }else{
            $(this).prop('disabled',false)
            alertify.alert('Message',"Please check your input");
        }
})

/**
 * 
 *  tab to next input
 * 
 */

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

const displayTable = () =>{
    let row=''
    console.log(rowCosting);
    rowCosting.forEach((item,i) => {
        row += `<tr>
                    <td>${item.itemName}</td>
                    <td>${item.quantity}</td>
                    <td>${item.taxCode}</td>
                    <td>${item.specialPrice}</td>
                    <td>${item.volumePrice}</td>
                    <td>${item.pickupPrice}</td>
                    <td>${item.brand}</td>
                    <td><b>${item.trucking}</b></td>
                    <td>${item.totalCosting}</td>
                    <td><button class="btn-link " type="button" name="moreCostingRow" data-id="${i}">View</button></td>
                    <td class="text-center">
                        <button class="btn-link text-center" name="removeRow" type="button" data-id="${i}"> Remove </button>
                        <button class="btn-link text-center" name="editRow" type="button" data-id="${i}"> Edit </button>
                    </td>
                </tr>`
    })
    if (rowCosting.length === 0) { // Check if `rowCosting` array is empty
        row += `<tr class="text-center">
                    <td colspan="10"><em>No data available</em></td>
                </tr>`
    }
    $("#myTable.table tbody").html(row);

    CostingForm.find("[name=totalNumCosting]").val(rowCosting.reduce((acc, row) => acc + (parseFloat(row.totalCosting)), 0));
    $("#copyCosting").modal("hide")
}

/**
 * 
 *  REMOVE ROW
 * 
 */

$("#myTable.table tbody").on("click", "button[name=removeRow]", function(){
    alertify.confirm("Do you want remove this item?", function (e) {
        if (e) {
            let id    = $(this).attr("data-id");
            rowCosting.splice(id,1);
            reAutoCompute(false)
        }
    }).set('movable', false); 
    
})

/**
 * 
 * EDIT ROW
 * 
 */

$(document).on("click", "button[name=editRow]", function(){
    let id = $(this).attr("data-id");
    let $row = $(this).closest('tr');
    let list = CostingData.inputFields().filter(item => item.tag === "offcanvas");
    Core.brandList(rowCosting[id].itemCode)
    for (const [key, value] of Object.entries(rowCosting[id])) {
        let newOption = new Option(rowCosting[id].itemName, rowCosting[id].itemCode);
        newOption.setAttribute('data-sku', rowCosting[id].sku);
        newOption.setAttribute('data-taxCode', rowCosting[id].taxCode);
        if (key === 'itemName') {
            CostingForm.find(`[name=${key}]`).empty().append(newOption).trigger('change.select2');
        }else if (key === 'brand') {
            setTimeout(() => {
                CostingForm.find(`select[name=brand]`).val(value);
                console.log("brand",value);
            },1000)
        }else{
            CostingForm.find(`[name=${key}]`).val(value);
        }
        for(let i = 0; i<list.length; i++){
            if(list[i].tag==="offcanvas" && list[i].name===key){
                tempCosting[key] = value
            }
        }
        
       
    }

    $row.addClass("highlighted")
    $row.find("button").prop("disabled", true); // disable all button in row
    $("button[name=addRow]").data("edit", 'Y').data("id",id).text('Update')
})


/**
 * 
 * DISPLAY PRICE INDEX
 * 
 */

$('select[name=warehouse_origin_id], select[name=itemName], select[name=company], select[name=taxCode], select[name=brand], select[name=volumePrice]').on('change', function (e) {
    e.stopPropagation()
    // Core.brandList(CostingForm.find("[name=itemCode]").val());
    setTimeout(() => {
        let   warehouse   = CostingForm.find("[name=warehouse_origin_id]").val();
        let   item        = CostingForm.find("select[name=itemName]").val() ?? CostingForm.find("input[name=itemCode]").val();
        let   brand       = CostingForm.find("select[name=brand]").val();
        let   company     = CostingForm.find("select[name=company]").val();
        let   taxCode     = CostingForm.find("select[name=taxCode]").val();
        let   volumePrice = CostingForm.find("select[name=volumePrice]").val();
        console.log(warehouse,item,brand,company,taxCode,volumePrice);        
        CostingData.getPriceIndex({
        _token:Core.token,company,taxCode,warehouse,item,brand,volumePrice
    })
    },1000)
                      
});

/**
 * 
 * TRUCKING RATE MATRIX
 * 
 */
   
$('select[name=warehouse_origin_id], select[name=province], select[name=municipality], select[name=trucktype_id], select[name=itemName]').on('change keyup', function () {
    let itemSelected        = CostingForm.find("select[name=itemName]").find(':selected').length > 0; // , input[name=quantity]
    let warehouse           = CostingForm.find("select[name=warehouse_origin_id]").val();
    let province            = CostingForm.find("select[name=province] :selected").text();
    let municipality        = CostingForm.find("select[name=municipality] :selected").text();
    let trucktype           = CostingForm.find("select[name=trucktype_id]").val();
    $.ajax({
        url: CostingForm.find("[name=trucking]").attr("data-url"),
        type: "POST",
        data: {
            _token: Core.token,
            warehouse,
            province,
            municipality,
            trucktype
        },
        dataType: "json",
        success: function(data) {
                                  CostingForm.find("[name=rate]").val(data.res);
            let sku             = CostingForm.find("[name=sku]").val()
            let quantity        = CostingForm.find("[name=quantity]").val();
            let capacity        = CostingForm.find("select[name=trucktype_id] :selected").attr("data-capacity");
            let rate            = data.res;
            CostingData.msgTruckingRate()
            let dataFinalRate      = Core.finalRate({sku,rate,capacity})
            // if(isFinite(final_Rate) &&!isNaN(final_Rate) && rowCosting.length==0){
            //     CostingForm.find("[name=trucking]").val(final_Rate);
            //     totalGrossPrice()
            // }else{
            //     reAutoCompute(true)
            // }
            dataFinalRate.then(res_rate => {
                CostingForm.find("[name=trucking]").val(res_rate);
            });
            
            totalGrossPrice()
        },
        error: function(data) {
            CostingForm.find("[name=rate]").val(null);
            CostingForm.find("[name=trucking]").val(null);
            totalGrossPrice()
        }
    });
        
    //  CostingData.getTruckingRate(warehouse,province,municipality,trucktype)
    // if (itemSelected) {
       
    // } else {
    //     CostingData.msgTruckingRate()
    // }
    
});



/**
 * 
 *  SUBMIT FORM
 * 
 */

CostingForm.on('submit', function (e) {
    e.preventDefault();
    let formData     = new FormData(this);
    let capacity     = CostingForm.find("[name=trucktype_id] :selected").attr("data-capacity"); // Get the selected option element
    let deliveryType = CostingForm.find("[name=deliveryType]").val();
    let bool = CostingData.checkTruckLoad(capacity,deliveryType);

    formData.append('province', CostingForm.find("[name=province] :selected").text());
    formData.append('item', CostingForm.find("[name=item] :selected").text());
    formData.append('client', CostingForm.find("[name=client] :selected").val());
    formData.append('deliveryType', deliveryType);
    formData.append('costing', JSON.stringify(rowCosting));
    formData.append('_token', Core.token);
    // Convert data to HTML table
    let tableHTML = '<table class="table table-bordered table-striped table-sm" style="border-collapse: collapse;"><thead><tr><th>Item</th><th>Quantity</th><th>Trucking</th></tr></thead><tbody>';
    rowCosting.forEach(row=>{
        tableHTML +=`</tbody>
        <tr>
            <td>${row.itemName}</td>
            <td>${row.quantity}</td>
            <td>${row.trucking}</td>
        </tr>`
    });
    tableHTML += '</tbody></table>';

    // Display the table in a confirm dialog
    alertify.confirm('Message',tableHTML, function(){
        alertify.success('Accepted');
    },function(){
        alertify.error('Declined');
    }).set('modal', false);



    // if (bool && Object.prototype.hasOwnProperty.call(bool, 'msg')) {
        

        
    //     alertify.confirm(bool.msg, function (e) {
    //         if (e) {
    //             CostingData.formSubmit(formData);
    //             formData.append('confirmation', 'YES');
    //             alertify.confirm().set({
    //                 labels : {
    //                     ok     : 'Confirm',
    //                     cancel : 'Cancel',
    //                 },
    //             });
    //             alertify.success("You've clicked saved");
    //         } else {
    //             alertify.confirm().set({
    //                 labels : {
    //                     ok     : 'Confirm',
    //                     cancel : 'Cancel',
    //                 },
    //             });
    //             alertify.error("You've Cancel");
    //         }
    //     });
    // }else{
    //     CostingData.formSubmit(formData);
    // }
       
          
});

/**
 * 
 * CHECK IF COLOAD COSTING
 * 
 */

// CostingForm.find("[name=isCoload]").on('click', function (e) {
//     e.stopPropagation();
//     let isColoadChecked = $(this).is(':checked');
//     let coloadQuantity  = CostingForm.find("[name=coloadQuantity]");
//     let coloadPkg       = CostingForm.find("[name=coloadPkg]");
//     // 
//     coloadQuantity.prop('readonly', !isColoadChecked)
//         .toggleClass('not-allowed', !isColoadChecked)
//         .val(isColoadChecked ? coloadQuantity.val() : '');

//     coloadPkg.prop('readonly', !isColoadChecked)
//         .toggleClass('not-allowed', !isColoadChecked)
//         .val(isColoadChecked ? coloadPkg.val() : '');

    
//     if (isColoadChecked) {
//         for (let i = 0; i < rowCosting.length; i++) {
//             previousTrucking[i] = rowCosting[i].trucking;
//         }
//     } else {
//         for (let i = 0; i < rowCosting.length; i++) {
//             rowCosting[i].trucking = previousTrucking[i]
//         }
//         previousTrucking.splice(0, rowCosting.length);
//         displayTable()
//     }
   

// })

// CostingForm.find("[name=coloadPkg]").on('keyup', function (e) {
//     // 
//     let cpkg       = $(this).val()
//     let cquantity  = CostingForm.find("[name=coloadQuantity]").val()
    
//     if (cquantity !== '' && parseInt(cquantity) !== 0 && cpkg !== '' && parseInt(cpkg) !== 0) {
//         autoCompute()
//     }
// })

// CostingForm.find("[name=coloadQuantity]").on('keyup', function (e) {
//     let cpkg       = $(this).val()
//     let cquantity  = CostingForm.find("[name=coloadQuantity]").val()
//     if (cquantity !== '' && parseInt(cquantity) !== 0 && cpkg !== '' && parseInt(cpkg) !== 0) {
//         autoCompute()
//     }
// })

function reAutoCompute(isNew) {
    let isEdit        = CostingForm.find("[name=addRow]").data("edit");
    let rate          = CostingForm.find("input[name=rate]").val();
    let qty           = CostingForm.find("[name=quantity]").val();
    let capacity      = CostingForm.find("select[name=trucktype_id] :selected").attr("data-capacity");
    let sku           = CostingForm.find("input[name=sku]").val();
    let getTypinginKg = isNew ? qty * sku : 0;
    let totalinKG     = rowCosting.reduce((acc, row) => acc + (parseInt(row.quantity * row.sku)), 0);
    let frate         = (capacity / (totalinKG + getTypinginKg)) * rate;
    // if (isNew && isFinite(((sku / 50) * frate).toFixed(5))) {
    if (isNew) {
        // CostingForm.find("[name=trucking]").val(((sku / 50) * rate).toFixed(5));
        let fdata = Core.finalRate({sku, rate, capacity})
        CostingForm.find("[name=trucking]").val(fdata.then(res => res));
    }
    if (isEdit == "N") {
        for (let i = 0; i < rowCosting.length; i++) {
            rowCosting[i].trucking = parseFloat((rowCosting[i].sku / 50) * frate).toFixed(5);
            // rowCosting[i].trucking = parseFloat((rowCosting[i].sku / 50) * rate).toFixed(5);
            console.log(rowCosting[i].sku);
        }
        displayTable();
    }

}


// $("input[name=quantity]").on('keyup', function (e) {
//     e.stopPropagation();
//     if (rowCosting.length > 0) {
//         reAutoCompute(true)
//     }
// })

/***
 * 
 * 
 *  COLOAD
 * 
 * 
 */


$("input[name=coloadInKls]").on('keyup', function (e) {
    let rate          = CostingForm.find("input[name=rate]").val();
    let capacity      = CostingForm.find("select[name=trucktype_id] :selected").attr("data-capacity");
    let totalRowinKG  = rowCosting.reduce((acc, row) => acc + (parseInt(row.quantity * row.sku)),0);
    let frate      = (capacity/(totalRowinKG+$(this).val()))*rate;
    for (let i = 0; i < rowCosting.length; i++) {
        final  = Core.finalRate({sku:rowCosting[i].sku,rate})
        rowCosting[i].trucking = parseFloat(final.then(res => res)).toFixed(5);
        // rowCosting[i].trucking = parseFloat((rowCosting[i].sku/50) * frate).toFixed(5);
    }
    displayTable()
})

/**
 * 
 * COPY COSTING
 * 
 */
let tableCopy


const tableCosting = () =>{
    tableCopy = $('#copyTable').DataTable({
        responsive: true,
        destroy:true,
        ajax: {
            url:$('#copyTable').attr("data-url"),
            type:'POST',
            data: function(d) {
                d._token = Core.token;
            },
        },
       
        columns: [
            { data: 'costingHeaderNo' },
            { data: 'client' },
            { 
                data: 'warehouse_origin.warehouse',
                
            },
            { 
                data: 'form',
            },
            { 
                data: 'paymentMode',
            },
            { 
                data: 'company',
            },
            { 
                data: 'trucktype.trucktype',
            },
            { 
                data: 'deliveryType',
                render:function(data){
                    switch (data) {
                        case "ONETIMEDELIVERY":
                                return "ONE TIME DELIVERY";
                            break;
                        case "STAGGERED":
                                return "STAGGERED";
                            break;
                    
                        default:
                                return ""
                            break;
                    }
                    
                }
            },
            { data: null,
                render:function(data){
                    let html = `
                    <table class="table border table-bordered copyTable1 table-dark">
                       <thead>
                            <tr>
                                <th>Costing No</th>
                                <th>Item Name</th>
                                <th>Brand</th>
                                <th>TaxCode</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Trucking</th>
                            </tr>
                       </thead>
                    `;
                    data.costing.forEach(x => {
                        html += `
                            <tr>
                                <td>${x.costingNo}</td>
                                <td>${x.itemName}</td>
                                <td>${x.brand}</td>
                                <td>${x.taxCode}</td>
                                <td class="text-left">${x.quantity}</td>
                                <td class="text-left">${x.pickupPrice}</td>
                                <td class="text-left">${x.trucking}</td>
                            </tr>
                        `;
                    });
                    html += '</table>';
                    return html;
                }
            },
            { data: null,
                render: function(data){
                    return `
                    <button type="button" name="copyBtn" class="btn btn-primary btn-sm text-center py-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-copy">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                        <path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                        </svg>Copy
                    </button>
                    `;
                }
            },
        ]
    });
}

$(".copyCosting").on('click',function(){
    tableCosting()
    $("#copyCosting").modal("show")
})


$('#copyTable tbody').click('button[name=copyBtn]', function (e) {
    e.stopPropagation()
    rowCosting.splice(0, rowCosting.length);
    let getData   =  tableCopy.row(e.target.closest('tr')).data();
    $.ajax({
        url:$('#copyTable').attr("data-copyURL").replace("id",getData.id),
        type:'GET',  
    }).done(function(data){
        CostingForm.find("[name=client]").append(new Option(data.header.client,data.header.client)).trigger('change');
        Core.provinceData()
        CostingForm.find("[name=province]").find('option:contains("' + data.header.province + '")').eq(0).prop('selected', true);
        Core.municipalityData($('select[name=province]').val())
        setTimeout(() => {
            CostingForm.find("[name=municipality]").val(data.header.municipality).trigger('change');
        }, 1000);
        CostingForm.find("[name=warehouse_origin_id]").val(data.header.warehouse_origin_id);
        CostingForm.find("[name=trucktype_id]").val(data.header.trucktype_id);
        CostingForm.find("[name=form]").val(data.header.form);
        CostingForm.find("[name=paymentMode]").val(data.header.paymentMode);
        CostingForm.find("[name=company]").val(data.header.company);
        CostingForm.find("[name=deliveryType]").val(data.header.deliveryType);
        if (data.body.some(item => Object.keys(item).some(key =>
            !['client', 'province', 'municipality', 'warehouse_origin_id', 'trucktype_id', 'form', 'paymentMode', 'company'].includes(key)
        ))) {
            data.body.forEach((element,key) => {
                rowCosting.push(element)
            });
        }
        displayTable()
    })

    
})
