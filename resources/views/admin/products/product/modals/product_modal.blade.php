<div class="modal fade custom-modal" id="product_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="product-form">
                    <div class="form-group">
                        <label for="">Product Name:<strong class="text-danger">*</strong></label>
                        <input type="text" name="product_name" class="form-control" id="product_name" required>
                        <small id="product_name_error" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Product Code:<strong class="text-danger">*</strong></label>
                        <input type="text" name="product_code" class="form-control" id="product_code" required>
                        <small id="product_code_error" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Product Category:<strong class="text-danger">*</strong></label>
                        <select name="product_category" id="product-categories" id="product_category" style="width: 100%" class="form-control select2-width" required>
                            @foreach($productCategories as $productCategory)
                                <option  value="{{$productCategory->id}}">{{$productCategory->name}}</option>
                            @endforeach
                        </select>
                        <small id="product_category_error" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Product Size:</label>
                        <input type="text" name="product_size" placeholder="200 ml" class="form-control" id="product_size" >
                    </div>
                    <div class="form-group">
                        <label for="">Product Unit:</label>
                        <input type="text" name="product_unit" placeholder="Bottle" class="form-control" id="product_unit" >
                    </div>
                    <div class="form-group">
                        <label for="">Product Description:</label>
                        <textarea name="product_description" id="product_description" cols="10" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
