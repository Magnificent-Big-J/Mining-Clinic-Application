
    @if ($row->status !== \App\Models\Appointment::ACCEPTED_STATUS && $row->status !== \App\Models\Appointment::DONE_STATUS)

            <a class="btn btn-info btn-sm" href="{{route('admin.reschedule.booking', $row->id)}}"> Reschedule </a>

    @elseif($row->status === \App\Models\Appointment::DONE_STATUS && $row->sales->count() === 0)

            <a class="btn btn-success btn-sm" href="{{route('admin.dispense.medicine', $row->id)}}"> Dispense Patient Medication </a>

    @endif
