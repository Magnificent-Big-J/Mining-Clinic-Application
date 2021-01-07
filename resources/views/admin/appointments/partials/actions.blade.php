<div class="row">
    @if ($row->status !== \App\Models\Appointment::ACCEPTED_STATUS && $row->status !== \App\Models\Appointment::DONE_STATUS)
        <div class="col-sm-6">
            <a class="btn btn-info btn-sm" href="{{route('admin.reschedule.booking', $row->id)}}"> Reschedule </a>
        </div>
        <div class="col-sm-6">
            <form action="{{route('admin.appointments.destroy', $row->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fe fe-trash"></i></button>
            </form>
        </div>
    @elseif($row->status === \App\Models\Appointment::DONE_STATUS && $row->sales->count() === 0)
        <div class="col-sm-6">
            <a class="btn btn-success btn-sm" href="{{route('admin.reschedule.booking', $row->id)}}"> Dispense Medication </a>
        </div>
    @endif

</div>

