<div class="modal fade custom-modal" id="mining-clinic-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Mining Clinic</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="mining-clinic-form"  action="javascript:void(0)">
                    <div id="loader"></div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Mining Name:<i class="fa fa-asterisk text-danger"></i></label>
                        <div class="col-lg-9">
                            <input type="text" name="mining_name" class="form-control" required>
                            <small class="text-danger" id="mining-name-error"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Clinic Name:<i class="fa fa-asterisk text-danger"></i></label>
                        <div class="col-lg-9">
                            <input type="text" name="clinic_name" class="form-control" required>
                            <small class="text-danger" id="clinic-name-error"></small>
                        </div>
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
