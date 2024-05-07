let loadCostingTable = $("#loadCostingTable")
let loadCostingTableInstance;
const loadCosting = () => {
    loadCostingTableInstance = loadCostingTable.DataTable({
        info: false,
        paging: false,
        searching: true,
        ajax: {
            url: loadCostingTable.data("url"),
            type:'GET',
            data:{
                grant:'all'
            }
        },
        columns: [
            {
                data: null,
                render: function(data, type, row, meta) {
                    const costingNo = data.costingNo;
                    const isChecked = dataCostingNo.includes(costingNo);
                    const checkbox = `<input type="checkbox" class="form-check-input m-0 p-0" value="${costingNo}" ${isChecked ? 'checked' : ''}>`;
                    return checkbox;
                }
            },
            { data: 'costingNo' },
            { data: 'client' },
            { data: 'item' },
            { data: 'quantity' },
            { data: 'trucktype' },
        ],
        destroy: true,
    });
    loadCostingTable.find(".dt-search").children("label").remove();
}

$("#truckerTypeButton").on('click', function () {
    dataCosting.splice(0);
    const id = null
    const quantity = $("[name=quantity]").val();
    const item = $("[name=item] :selected").text();
    dataCosting.push({
        id,
        quantity,
        item
    });
    console.log(dataCosting);
    if($("[name=truckerType]").val() === "COLOAD" && $("[name=quantity]").val()!=0) {
        loadCosting()
        
        loadData()
        $("#loadCosting").modal("show")
    }else{
        alertify.set('notifier','position', 'top-right');
        alertify.warning('Please select COLOAD and check that your quantity should not be zero.');
    }
})

$(document).on('change', '#loadCostingTable input[type="checkbox"]', function() {
    let row = $(this).closest("tr");
    let obj = loadCostingTable.DataTable().row(row).data();
    let index = dataCosting.findIndex((d) => d.id === obj.id);
    if ($(this).is(":checked")) {
        if (index === -1) {
            dataCosting.push({
                id: obj.id,
                quantity: obj.quantity,
                item: obj.item
            })
            dataCostingNo.push(obj.costingNo)
        }
    } else {
        if (index !== -1) {
            dataCosting.splice(index, 1);
            
            let idx = dataCostingNo.indexOf(obj.costingNo);
            console.log(idx);
            dataCostingNo.splice(idx, idx !== -1 ? 1 : 0);
        } 
    }
    loadData()
    console.log(dataCostingNo);
})

const loadData = () => {
    const list = $("#listCosting");
    list.empty();
    const table = $('<table class="table table-sm table-bordered table-sm" style="font-size: 12px"></table>');
    const thead = $('<thead class="text-center"></thead>');
    const tbody = $('<tbody></tbody>');
    const trHead = $('<tr></tr>');
    const th1 = $('<th></th>').text('QTY');
    const th2 = $('<th></th>').text('ITEM DECRIPTION');
    trHead.append(th1, th2);
    thead.append(trHead);
    table.append(thead, tbody);
    dataCosting.forEach((data) => {
        const tr = $('<tr></tr>');
        const td3 = $('<td></td>').text(data.quantity);
        const td4 = $('<td></td>').text(data.item);
        tr.append(td3, td4);
        tbody.append(tr);
    })
    list.append(table);
}