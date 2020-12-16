<div class="modal fade custom-modal" id="update-threshold-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="product-form">
                    <div class="form-group">
                        <input type="hidden" name="doctorProduct"  id="doctor-product-value">
                        <label for="">Product Threshold:<strong class="text-danger">*</strong></label>
                        <input type="number" id="threshold" class="form-control">
                        <small id="product_category_error" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Product Price:<strong class="text-danger">*</strong></label>
                        <input type="text" id="price" class="form-control">
                        <small id="product_category_error" class="text-danger"></small>
                    </div>

                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary update-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
