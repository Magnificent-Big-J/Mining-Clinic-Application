<div class="modal fade custom-modal" id="prescription-upload">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Prescription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="prescription-form">
                    @csrf
                    <input type="hidden" name="appointment" value="{{$appointment->id}}">
                    <input type="hidden" name="document" value="{{$document_type[0]->id}}">
                    <div class="form-group">
                        <label for="">Prescription File:<strong class="text-danger">*</strong></label>
                        <input type="file" accept="image/gif, image/jpeg, image/png, application/pdf" name="prescription"  class="form-control" required>
                        <small class="text-danger" id="prescription_error"></small>
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-prescription">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
