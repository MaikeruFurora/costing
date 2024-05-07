<!-- Modal -->
<div class="modal fade" id="viewTransaction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewTransactionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header py-1">
        <p class="modal-title p-1" id="viewTransactionLabel" style="font-size: 12px">Previous transaction on this client based on item</p>
        <button type="button" class="btn-close p-0" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-2 py-0">
        {{-- <div class="table-responsive"> --}}
          <table id="previousTransactionTable" data-url="{{ route('costing.prev.transaction') }}" class="table table-stripped table-hover my-2 nowrap" style="font-size: 10px;width:100%">
            <thead class="border">
                <tr>
                  <td width="3%">COPY</td>
                  <td>COSTING NO.</td>
                  <td>WAREHOUSE</td>
                  <td>CLIENT</td>
                  <td>ITEM</td>
                  <td>QUANTITY</td>
                  <td>PICK UP PRICE</td>
                </tr>
            </thead>
            <tbody>
              <tr class="text-center">
                <td colspan="4">No Data available</td>
              </tr>
            </tbody>
          </table>
        {{-- </div> --}}
      </div>
      <div class="modal-footer p-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        {{-- <button type="button" class="btn btn-primary">Choose item</button> --}}
      </div>
    </div>
  </div>
</div>