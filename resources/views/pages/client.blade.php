@extends('../layout/app', ['title' => 'Adjustment'])
@section('content')
    <h1 class="h3 mb-3">Client Form</h1>

    <div class="row">
        <div class="col">
            <div class="card ">
                <div class="card-header">
                    <h5 class="card-title mb-0">Details</h5>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-4">
                            <form id="clientadd">
                                <br>
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Client</label>
                                    <select class="form-control" name="client" id="client"></select>
                                </div>
                                <div class="form-group">
                                    <label>Province</label>
                                    <select class="form-control" name="province" id="province" required></select>
                                </div>
                                <div class="form-group">
                                    <label>Municipality</label>
                                    <select class="form-control" name="municipality" id="muni" required></select>
                                </div>

                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="Main">Main</option>
                                        <option value="Branch">Branch</option>
                                    </select>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary" id="clientform">Submit</button>
                            </form>
                        </div>
                        <div class="col-8">
                            <br>
                            <table id="myTableClients" class="display">
                                <thead>
                                    <tr>
                                        <th scope="col">Client</th>
                                        <th scope="col">Province</th>
                                        <th scope="col">Municipality</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Active</th>
                                        <th scope="col">Alias</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/datatable/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/dataTables.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/responsive.bootstrap5.js') }}"></script>
    <!-- Libs JS -->
    <script src="./dist/libs/list.js/dist/list.min.js"></script>
  
    <script>



        $('#clientadd').on('submit', function(e){

            e.preventDefault();

            Swal.fire({
            title: "Do you want to save the changes?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('clients_store') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            client: $("#client").text(),
                            province: $("#province").text(),
                            muni: $("#muni").text(),
                            type: $("#type option:selected").val(),
                        },
                        success: function(msg) {
                            $('#clientadd').trigger("reset");
                           
                            $('#myTableClients').DataTable().ajax.reload();
                        }
                    });
                    $('#clientadd').trigger("reset");
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });

        });


        $('select[name=province]').select2({
            tags:true,
            minimumResultsForSearch: -1,
            ajax: {
                url:'https://psgc.gitlab.io/api/island-groups/luzon/provinces.json'
                // url: 'https://psgc.gitlab.io/api/provinces/',
                dataType: 'json',
                processResults: function (data) {
                    $('select[name=muni]').empty();
                    // console.log(data)
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.cod+'+'+item.name,
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('select[name=province]').on('select2:select', function (e) {
           let code=e.params.data.id.split('+')[0];
            $('select[name=muni]').select2({
                tags:true,
                ajax: {
                    url: `https://psgc.gitlab.io/api/provinces/${code}/cities-municipalities/`,
                    dataType: 'json',
                    processResults: function (data) {

                        // console.log(data)
                        return {
                            results:  $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.code,
                                }
                            })
                        };
                    },
                    cache: true
                }
            })
        });

        $('select[name=client]').select2({
            tags:true,
            ajax: {
                url: '{{ route('api_clients') }}',
                dataType: 'json',
                processResults: function (data) {
                    $('select[name=muni]').empty();
                    // console.log(data)
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.cardname,
                                id: item.cardname,
                            }
                        })
                    };
                },
                cache: true
            }
        });

        

        $('#myTableClients').DataTable({
            ajax: "{{ route('api_showClients') }}",
            columns: [
                { data: 'name', title: 'Client'},
                { data: 'province', title: 'Province'},
                { data: 'municipality', title: 'Municipality'},
                { data: 'type', title: 'Type'},
                { data: 'active', title: 'Active'},
                { data: 'alias', title: 'Alias'}
            ]
        });
    </script>
@endsection
