<div class="modal fade custom-modal" id="specialist_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Specialist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="specialist-form" enctype="multipart/form-data">
                   <div id="loader"></div>
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group ">
                                <label  for="">Specialist Name: <strong class="text-danger">*</strong></label>
                                <input type="text" id="specialist_name" name="specialist_name" class="form-control" required>
                                <small class="text-danger" id="specialist-name-error"></small>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group ">
                                <label for="">Specialist Image:<strong class="text-danger">*</strong></label>
                                <br>
                                <input type="file" name="specialist_image" accept="image/gif, image/jpeg, image/png" class="form-control" required>

                                <small class="text-danger" id="specialist-image-error"></small>
                            </div>
                        </div>
                    </div>

                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-specialist">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
