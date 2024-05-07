
<!-- Modal -->
<div class="modal fade" id="loadCosting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loadCostingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header py-1">
          <p class="modal-title p-1" id="loadCostingLabel" style="font-size: 12px">Coload Costing</p>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body px-2 py-0">
          <div class="row">
            <div class="col-12 py-2">
              <div class="card">
                <div class="card-header py-2">
                  List
                </div>
                <div class="card-body py-0 px-0 my-0 mx-1">
                  <table id="loadCostingTable" class="table table-striped table-sm table-hover py-1" style="font-size: 10px;width:100%" data-url="{{ route("costing.load") }}">
                    <thead class="border ">
                      <tr>
                        <th class="border" width="3%">ADD</th>
                        <th class="border" width="5%">COST NO.</th>
                        <th class="border">CLIENT</th>
                        <th class="border">ITEM</th>
                        <th class="border" width="5%">QUANTITY</th>
                        <th class="border" width="5%">TRUCK TYPE</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-center" colspan="6">NO DATA AVAILABLE</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            {{-- <div class="col-4 py-2">
              <div class="card">
                <div class="card-header py-2">
                  Co-Load list
                </div>
                  <div class="card-body px-0 py-0" id="listCosting">
                      
                  </div>
              </div>
            </div> --}}
          </div>
        </div>
        <div class="modal-footer p-0">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>