const Core = {
    token: $("meta[name=token]").attr('content'),
    rateURL: $("meta[name=getFinalRate]").attr('content'),
    finalRate: function(params) {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: Core.rateURL,
                data: params,
                success: function(data) {
                    resolve(parseFloat(data).toFixed(5));
                },
                error: function(msg) {
                    reject(new Error("Failed to calculate rate"));
                }
            });
        });
    },

     // let equationOne = capacity/(pkg*quantity);
        // let equationTwo = (pkg/50)*rate;
        // let final       = equationOne * equationTwo
        // // return equationTwo;
        // return parseFloat(final).toFixed(2);

    provinceData: function () {
        $.ajax({
            url: $('[name=province]').data('url'),
            dataType: 'json',
            success: function (data) {
                localStorage.setItem('provinces', JSON.stringify(data));
            },
            complete: function (data) {
                let provinceData = JSON.parse(localStorage.getItem('provinces'));
                provinceData = provinceData.RECORDS.sort((a, b) => a.provDesc.localeCompare(b.provDesc));
                $('select[name=province]').select2({
                    data: $.map(provinceData, function (item) {
                        return {
                            text: item.provDesc,
                            id: item.provCode,
                            name:item.provDesc,
                        }
                    }),
                    // minimumResultsForSearch: Infinity, // Disable search
                    cache: true
                }).append('<option></option>')
            }
        });
   },

   municipalityData: function (code) {
    let dataArr = [];
    $.ajax({
        url: $('[name=municipality]').data('url'),
        dataType: 'json',
        success: function (data) {
            $('select[name=municipality]').empty().append('<option></option>')
            dataArr = data.RECORDS.filter(x => x.provCode ===code ).sort((a, b) => a.citymunDesc.localeCompare(b.citymunDesc))
        },
        complete:function(){
            $('select[name=municipality]').select2({
                data: $.map(dataArr, function (item) {
                    return {
                        text: item.citymunDesc,
                        id: item.citymunDesc,
                    }
                }),
                cache: true
            }).prop('disabled',false)
        }
    });
    $('select[name=municipality]').prop('disabled',true)
   },

   brandList:function(itemcode){
    let select = $("[name=brand]");
    $.ajax({
        type: "GET",
        url: select.attr("data-url"),
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
            $("[name=brand]").val('');
        }
    });
},
   
}

$('input, textarea').on('click',function(){
    $(this).select();
})

