
<a href="{{route('doctor.appointment.details', $appointment->id)}}" class="btn btn-sm bg-info-light">
    <i class="far fa-eye"></i> View
</a>
<a href="{{route('doctor.refer.patient', $appointment->id)}}" class="btn btn-sm bg-warning-light">
    <i class="far fa-eye"></i> Refer
</a>
@if($appointment->status === \App\Models\Appointment::PENDING_STATUS)
    <form action="{{route('doctor.appointment.update', $appointment->id)}}" method="post">
        <input type="hidden" name="status" value="{{\App\Models\Appointment::ACCEPTED_STATUS}}">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-sm bg-success-light mx-1">
            <i class="fa fa-check"></i> Accept
        </button>
    </form>
    <form action="{{route('doctor.appointment.update', $appointment->id)}}" method="post">
        <input type="hidden" name="status" value="{{\App\Models\Appointment::DECLINED_STATUS}}">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-sm bg-danger-light mx-1">
            <i class="fa fa-times"></i> Decline
        </button>
    </form>
@elseif ($appointment->status === \App\Models\Appointment::ACCEPTED_STATUS)
    <form action="{{route('doctor.appointment.update', $appointment->id)}}" method="post">
        <input type="hidden" name="status" value="{{\App\Models\Appointment::DONE_STATUS}}">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-sm bg-success-light mx-1">
            <i class="fa fa-check"></i> Mark as Done
        </button>
    </form>
    @if ($appointment->prescriptions->count())
        <a href="{{route('doctor.patient.prescription', $appointment->id)}}" class="btn btn-sm bg-primary">
            <i class="far fa-asterisk"></i> View Prescriptions
        </a>
        <form action="{{route('doctor.patient.prescription.delete', $appointment->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm bg-danger mx-1">
                <i class="fa fa-check"></i> Delete All Prescriptions
            </button>
        </form>
    @else
        @if (!$appointment->isPrescription())
            <a href="{{route('doctor.prescriptions.appointment.index', $appointment->id)}}" class="btn btn-sm bg-primary-light">
                <i class="far fa-asterisk"></i> Capture Prescriptions
            </a>
            @else
            {{$appointment->isPrescription()}}
        @endif
    @endif

        @if ($appointment->isXray())
            <a href="{{route('doctor.patient.show.document', $appointment->id)}}" class="btn btn-sm bg-info-light">
                <i class="far fa-eye"></i> View X-Ray
            </a>
        @endif

        @if (!$appointment->isPrescription() && !$appointment->prescriptions->count())
            <a href="{{route('doctor.patient.prescription.upload', $appointment->id)}}" class="btn btn-sm bg-info-light">
                <i class="far fa-asterisk"></i> Upload Prescription
            </a>
        @endif
        @if (!$appointment->isXray())
            <a href="{{route('doctor.patient.xray.create', $appointment->id)}}" class="btn btn-sm bg-primary-light">
                <i class="far fa-asterisk"></i> Upload Xray(s)
            </a>
        @endif

@endif

