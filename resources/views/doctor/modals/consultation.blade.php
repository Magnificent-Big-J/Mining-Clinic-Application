<div class="modal fade custom-modal" id="doctor-consultation-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mr-2">Select All Consultation For This Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" id="consultation-form">
                    @csrf
                    <input type="hidden" name="appointment" id="appointment">

                    <div class="form-group">
                        <label for="">Select Consultation:<span class="text-danger">*</span></label>
                        <select name="consultations[]" id="doctor-consultation" multiple style="width: 100%" class="form-control select2-width" required>
                            @foreach($consultationFees as $consultation)
                                <option  value="{{$consultation->id}}">{{$consultation->consultation->name}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="consultation-error"></small>
                    </div>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-doctor-consultation">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
