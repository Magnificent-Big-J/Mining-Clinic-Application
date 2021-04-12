<div class="modal fade custom-modal" id="has-medical-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Medical Aid</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="medical-aid-form"  action="javascript:void(0)">
                    <div id="loader"></div>
                    <input type="hidden" name="patient" id="patient">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Medical Aid Name:<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="medical_name" class="form-control" required>
                            <small class="text-danger" id="medical-aid-error"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Medical Aid Number:<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="medical_aid_number" class="form-control" required>
                            <small class="text-danger" id="medical-aid-number-error"></small>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Medical Email Address:<span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="email" name="medical_email_address" class="form-control" required>
                            <small class="text-danger" id="medical-aid-email-error"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Medical Aid Plan:</label>
                        <div class="col-lg-9">
                            <input type="text" name="plan"  class="form-control">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Medical Aid Status:</label>
                        <div class="col-lg-9">
                            <select name="status" id="status" class="form-control">
                                @foreach($status as $key=> $stat)
                                    <option value="{{$key}}">
                                        {{$stat}}
                                    </option>
                                @endforeach
                            </select>
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
