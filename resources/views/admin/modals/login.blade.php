<div class="modal fade custom-modal" id="clinic-login-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select the mining clinic you're working at today</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="loader"></div>
                <form method="post" id="clinic-login-form">
                    @csrf

                    <div class="form-group">
                        <label for="">Select Consultation:<span class="text-danger">*</span></label>
                        <select name="clinic" id="clinic"  required>
                            @foreach($clinics as $clinic)
                            <option  value="{{$clinic->id}}">{{$clinic->mining_name}} {{$clinic->clinic_name}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="clinic-error"></small>
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary clinic-login">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
