<div class="row">
    <div class="col-sm-2  mb-2">
        <a href="{{route('doctor.appointment.details', $appointment->id)}}" class="btn btn-sm bg-info-light">
            <i class="far fa-eye"></i> View
        </a>
    </div>
    <div class="col-sm-2  mb-2">
        <a href="{{route('doctor.refer.patient', $appointment->id)}}" class="btn btn-sm bg-warning-light">
            <i class="far fa-eye"></i> Refer
        </a>
    </div>
    @if ($appointment->appointmentAssessment->count() === 0)
        <a data-toggle="modal" href="#doctor-consultation-modal" id="{{$appointment->id}}" class="btn btn-sm bg-info-light capture-doctor-consultation">
            <i class="far fa-eye"></i> Select Consultations
        </a>
    @endif

    @if($appointment->status === \App\Models\Appointment::PENDING_STATUS)
        <div class="col-sm-2 mb-2">
            <form action="{{route('doctor.appointment.update', $appointment->id)}}" method="post">
                <input type="hidden" name="status" value="{{\App\Models\Appointment::ACCEPTED_STATUS}}">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-sm bg-success-light mx-1">
                    <i class="fa fa-check"></i> Accept
                </button>
            </form>
        </div>
        <div class="col-sm-2 mb-2">
            <form action="{{route('doctor.appointment.update', $appointment->id)}}" method="post">
                <input type="hidden" name="status" value="{{\App\Models\Appointment::DECLINED_STATUS}}">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-sm bg-danger-light mx-1">
                    <i class="fa fa-times"></i> Decline
                </button>
            </form>
        </div>
    @elseif ($appointment->status === \App\Models\Appointment::ACCEPTED_STATUS)
        <div class="col-sm-2 mb-2">
            <form action="{{route('doctor.appointment.update', $appointment->id)}}" method="post">
                <input type="hidden" name="status" value="{{\App\Models\Appointment::DONE_STATUS}}">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-sm bg-success-light mx-1">
                    <i class="fa fa-check"></i> Mark as Done
                </button>
            </form>
        </div>
        @if ($appointment->prescriptions->count())
            <div class="col-sm-2 mb-2">
                <a href="{{route('doctor.patient.prescription', $appointment->id)}}" class="btn btn-sm bg-primary">
                    <i class="far fa-asterisk"></i> View Prescriptions
                </a>
            </div>
            <div class="col-sm-2 mb-2">
                <form action="{{route('doctor.patient.prescription.delete', $appointment->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm bg-danger mx-1">
                        <i class="fa fa-check"></i> Delete All Prescriptions
                    </button>
                </form>
            </div>
        @else
            @if (!$appointment->isPrescription())
                <div class="col-sm-2 mb-2">
                 <a href="{{route('doctor.prescriptions.appointment.index', $appointment->id)}}" class="btn btn-sm bg-primary-light">
                    <i class="far fa-asterisk"></i> Capture Prescriptions
                    </a>
                </div>
            @else
                {{$appointment->isPrescription()}}
            @endif
        @endif

        @if ($appointment->isXray())
            <div class="col-sm-2  mb-2">
                <a href="{{route('doctor.patient.show.document', $appointment->id)}}" class="btn btn-sm bg-info-light">
                    <i class="far fa-eye"></i> View X-Ray
                </a>
            </div>
        @endif

        @if (!$appointment->isPrescription() && !$appointment->prescriptions->count())
            <div class="col-sm-2  mb-2">
                <a href="{{route('doctor.patient.prescription.upload', $appointment->id)}}" class="btn btn-sm bg-info-light">
                    <i class="far fa-asterisk"></i> Upload Prescription
                </a>
            </div>
        @endif
        @if (!$appointment->isXray())
            <div class="col-sm-2  mb-2">
                <a href="{{route('doctor.patient.xray.create', $appointment->id)}}" class="btn btn-sm bg-primary-light">
                    <i class="far fa-asterisk"></i> Upload Xray(s)
                </a>
            </div>
        @endif

    @endif

</div>
