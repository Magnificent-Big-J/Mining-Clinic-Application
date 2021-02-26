<div class="modal fade custom-modal" id="edit-medical-aid-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Medical Aid</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="edit-medical-aid-form"  action="javascript:void(0)">
                   <div id="add-loader">

                   </div>
                    <input type="hidden" name="medical" id="medical">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Medical Aid Name:<i class="fa fa-asterisk text-danger"></i></label>
                        <div class="col-lg-9">
                            <input type="text" name="medical_name" class="form-control"  id="medical-aid-name" required>
                            <small class="text-danger" id="medical-aid-error2"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Medical Aid Number:<i class="fa fa-asterisk text-danger"></i></label>
                        <div class="col-lg-9">
                            <input type="text" name="medical_aid_number" id="medical-aid-number" class="form-control" required>
                            <small class="text-danger" id="medical-aid-number-error2"></small>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Medical Email Address:<i class="fa fa-asterisk text-danger"></i></label>
                        <div class="col-lg-9">
                            <input type="email" name="medical_email_address" id="medical-aid-email" class="form-control" required>
                            <small class="text-danger" id="medical-aid-email-error2"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Medical Aid Plan:</label>
                        <div class="col-lg-9">
                            <input type="text" name="plan" id="medical-aid-plan" class="form-control">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Medical Aid Plan:</label>
                        <div class="col-lg-9">
                            <select name="status" id="medical-aid-status" class="form-control">
                                @foreach($status as $key=> $stat)
                                    <option value="{{$key}}">
                                        {{$stat}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary ">update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
