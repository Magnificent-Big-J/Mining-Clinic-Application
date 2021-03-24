<div class="modal fade custom-modal" id="edit-mining-clinic-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Mining Clinic</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="edit-mining-clinic-form"  action="javascript:void(0)">
                    <div id="loader" style="display: none;"></div>
                    <input type="hidden" name="clinic" id="clinic">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Mining Name:<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="mining_name" id="mining-name" class="form-control" required>
                            <small class="text-danger" id="error-mining-name"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Clinic Name:<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="clinic_name" id="clinic-name" class="form-control" required>
                            <small class="text-danger" id="error-clinic-name"></small>
                        </div>
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
