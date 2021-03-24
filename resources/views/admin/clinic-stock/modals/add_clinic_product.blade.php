<div class="modal fade custom-modal" id="add-clinic-product-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Doctor Product </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="product-form">
                    <div class="form-group">
                        <input type="hidden" name="clinicProduct" value="{{$clinic}}" id="clinic-product">
                        <label for="">Product Name:<span class="text-danger">*</span></label>
                        <select name="clinic_product" id="clinic-product-select" multiple style="width: 100%" class="form-control select2-width" required>
                            @foreach($products as $product)
                                <option  value="{{$product->id}}">{{$product->product_code}} {{$product->product_name}}</option>
                            @endforeach
                        </select>
                        <small id="product_category_error" class="text-danger"></small>
                    </div>

                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-click-product-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
