<div class="modal fade custom-modal" id="product_update_category_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="edit-product-category">
                    <div id="loader"></div>
                    <input type="hidden" name="category_id" id="category_id">
                    <div class="form-group">
                        <label for="">Name:<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="name" required>

                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary update-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
