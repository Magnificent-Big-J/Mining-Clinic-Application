<div class="modal fade custom-modal" id="consultation_category_update_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Consultation Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="loader"></div>
                <form name="update-category">
                    <input type="hidden" name="category_id" id="category_id">
                    <div class="form-group">
                        <label for="">Name:<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control"  required>
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary update-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
