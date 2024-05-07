<div class="modal modal-blur fade" id="copyCosting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="copyCostingLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header px-1 py-1">
            <h6 class="modal-title" id="copyCostingLabel">&nbsp;&nbsp;Costing Record</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body px-1 py-1">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered  nowrap m-0"  id="copyTable" data-url="{{ route('costing.new.list') }}" data-copyURL="{{ route('costing.copy',['id']) }}"  style="width:100%">
                        <thead>
                            <tr>
                                <th width="2%">No.</th>
                                <th>Client</th>
                                <th width="3%">Warehouse</th>
                                <th width="3%">Form</th>
                                <th width="3%">Payment Mode</th>
                                <th width="3%">Company</th>
                                <th width="5%">Truck Type</th>
                                <th width="5%">Delivery Type</th>
                                <th>Item</th>
                                <th width="2%">Action</th>
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