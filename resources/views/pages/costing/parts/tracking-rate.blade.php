<div class="offcanvas offcanvas-end" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h2 class="offcanvas-title" id="offcanvasStartLabel">Trucking Rate</h2>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="TruckerRateForm" action="{{ route('api_getTruckRate') }}">@csrf
        <div class="card mb-3">
            <div class="card-header">
               Trucking Rate Matrix
            </div>
            <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Province</label>
                        <select class="form-control" name="province" required></select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Area</label>
                        <select class="form-control" name="municipality" required></select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Truck Type</label>
                        <select name="trucktype_id"  class="form-control" required>
                            <option value=""></option>
                            @foreach ($trucktype as $item)
                                <option value="{{ $item->id }}">{{  $item->trucktype }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{--  --}}
            <div class="card mb-2">
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label class="form-label">Rate</label>
                        <input type="number" class="form-control" name="rate" readonly/>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">SKU</label>
                        <input type="number" class="form-control" name="sku" readonly/>
                    </div>
                    
                </div>
            </div>
        </form>

        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea placeat minima cupiditate saepe odio omnis repudiandae aliquam explicabo doloremque natus voluptates, culpa optio reprehenderit earum quos. Fugiat dolores iure veritatis!</p>
        <p>Final Rate = (PKG/50KG) <sup>x</sup> Truking rate</p>
    </div>
  </div>