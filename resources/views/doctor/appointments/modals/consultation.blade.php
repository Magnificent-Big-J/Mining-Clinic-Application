<!-- Appointment Details Modal -->

<div class="modal fade custom-modal" id="appointment-consultation">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <p >Select Appointment Consultation</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="row">

                        @foreach($consultationFees as $consultation)
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">{{$consultation->consultation->name}}</label>
                                    <input type="checkbox" name="consultations[]" id="consultation" value="{{$consultation->id}}" class="form-controntrol">
                                </div>
                            </div>
                        @endforeach
                    </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Add Appointment Consultation</button>
            </div>
        </div>
    </div>
</div>

<!-- /Appointment Details Modal -->
