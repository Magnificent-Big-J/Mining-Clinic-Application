
<a href="{{route('doctor.appointment.details', $appointment->id)}}" class="btn btn-sm bg-info-light">
    <i class="far fa-eye"></i> View
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
@endif

