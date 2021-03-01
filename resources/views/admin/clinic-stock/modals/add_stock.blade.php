<div class="modal fade custom-modal" id="add-clinic-stock-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title clinic-add-heading"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="product-form">
                    <div class="form-group">
                        <input type="hidden" name="stock"  id="stock">
                        <label for="">Product Quantity:<strong class="text-danger">*</strong></label>
                        <input type="number" name="product_quantity" id="product_quantity" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Stock Date:<strong class="text-danger">*</strong></label>
                        <input type="date" name="stock_date" id="stock_date" class="form-control">
                    </div>

                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary add-stock-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
