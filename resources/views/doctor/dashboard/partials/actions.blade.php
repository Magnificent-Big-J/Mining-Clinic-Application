<div class="row">
    <div class="col-sm-2">
        <a href="{{route('doctor.appointment.details', $appointment->id)}}" class="btn btn-sm bg-info-light">
            <i class="far fa-eye"></i> View
        </a>
    </div>
    @if($appointment->status === \App\Models\Appointment::PENDING_STATUS)
        <div class="col-sm-2">
            <form action="{{route('doctor.appointment.update', $appointment->id)}}" method="post">
                <input type="hidden" name="status" value="{{\App\Models\Appointment::ACCEPTED_STATUS}}">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-sm bg-success-light mx-1">
                    <i class="fa fa-check"></i> Accept
                </button>
            </form>
        </div>
        <div class="col-sm-2">
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
        @if ($appointment->prescriptions->count())

            <div class="col-sm-2">
                <form action="{{route('doctor.appointment.update', $appointment->id)}}" method="post">
                    <input type="hidden" name="status" value="{{\App\Models\Appointment::DONE_STATUS}}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm bg-success-light mx-1">
                        <i class="fa fa-check"></i> Mark as Done
                    </button>
                </form>
            </div>
        @else
            <div class="col-sm-2">
                <a href="{{route('doctor.prescriptions.appointment.index', $appointment->id)}}" class="btn btn-sm bg-primary-light">
                    <i class="far fa-asterisk"></i> Capture Prescriptions
                </a>
            </div>
        @endif
    @endif
</div>

