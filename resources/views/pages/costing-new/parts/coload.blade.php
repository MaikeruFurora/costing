<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header px-1 py-1">
            <h6 class="modal-title" id="staticBackdropLabel">Coload</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body px-1 py-1">
                <div class="table-responsive">
                    <table id="coloadTable" class="table table-bordered table-hover mb-1" style="width:100%;font-size: 12px">
                        <thead >
                            <tr>
                                <th>ITEM</th>
                                <th width="15%">QUANTITY</th>
                                <th width="5%">ACTION</th>
                            </tr>
                        </thead>
                        <thead class="sub-header">
                            <tr>
                                <th><select class="form-control " name="coloadItemName" data-url="{{ route('api_items') }}" style="width: 100%"></select></th>
                                <th><input type="number" class="form-control" name="coloadQuantity" value=""></th>
                                <th>
                                    <div class="d-grid gap-1">
                                        <button type="button" class="btn btn-primary" name="coloadAddRow">Add
                                        </button>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td colspan="10"><em>No data available</em></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>