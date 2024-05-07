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
            { data: 'costingHeaderNo' },
            { data: 'client' },
            { 
                data: 'warehouse_origin.warehouse',
                
            },
            { data: 'province.toUpperCase()' },
            { data: 'municipality.toUpperCase()' },
            { data: 'paymentMode' },
            { data: 'truckCategory' },
            { 
                data: 'trucktype.trucktype',
            },
            // { data: 'deliveryType' },
            { data: 'form' },
            { data: null,
                render:function(data){
                    let html = `
                    <table class="table border copyTable">
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
                        console.log(x.trucking.trucking);
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
                    return '<button type="button" name="view" class="btn btn-primary btn-sm text-center py-0" data-bs-toggle="modal" data-bs-target="#viewTransaction" data-id="'+data.id+'">View</button>';
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
            if (typeof value !== 'object') {  // dont display object
                if (key.indexOf('_id') === -1 && value !== null && value !== '' && value !== '0.0') {
                    let listItem = $('<li class="list-group-item d-flex justify-content-between align-items-center py-2 px-2"></li>');
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

    }

        
      
        let costingLists = Object.values(data.costing).map((costing) => Object.entries(costing));
        let accordion = $('<div id="accordionCosting" class="accordion m-0 border p-1 mt-3"></div>');
        let index = 0;
        for (const costingList of costingLists) {
            let header = $('<div class="accordion-header border" id="headingCosting'+index+'"></div>');
            let title = $('<button class="accordion-button collapsed p-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCosting'+index+'" aria-expanded="true" aria-controls="collapseCosting'+index+'"></button>');
            let itemName = costingList.find(([key, value]) => key === 'itemName')[1]; // get itemName
            title.text(itemName); // set itemName as title
            header.append(title);
            let collapse = $('<div id="collapseCosting'+index+'" class="accordion-collapse collapse" aria-labelledby="headingCosting'+index+'" data-bs-parent="#accordionCosting"></div>');
            let body = $('<div class="accordion-body p-1"></div>');
            let listGroup = $('<ul class="list-group list-group-flush"></ul>');
            for (const [key, value] of costingList) {
                if (!['id','sku', 'totalCosting','costing_header_id','rate', 'created_at', 'updated_at'].includes(key) && value != 0 && value != null) {
                    let listItem = $('<li class="list-group-item border d-flex justify-content-between align-items-center py-2 px-1"></li>');
                    let keySplit = key.replace(/([A-Z])/g, ' $1').trim();
                    let keyParts = keySplit.split(' ');
                    let finalKey = keyParts.map((word, index) => index === 0 ? word.charAt(0).toUpperCase() + word.slice(1).toLowerCase() : word).join(' ');
                    let keyDiv = $('<span class="fw-bold" style="font-size: 12px"></span>').text(finalKey);
                    let valueDiv = $('<span style="font-size: 12px"></span>');
                    if (typeof value === 'number' && value !== 0) {
                        valueDiv.text(value.toFixed(3));
                    } else if (typeof value === 'string') {
                        valueDiv.text(value.toUpperCase());
                    } else {
                        valueDiv.html(value);
                    }
                    if (value !== 0) {
                        listItem.append(keyDiv, valueDiv);
                        listGroup.append(listItem);
                    }
                }
            }
            body.append(listGroup);
            collapse.append(body);
            header.appendTo(accordion);
            collapse.appendTo(accordion);
            index++;
        }
        listGroup.append(accordion);




        
        $("#offcanvasRight .offcanvas-body").html(listGroup);
       $("#offcanvasRight").offcanvas('show');
    });
   })