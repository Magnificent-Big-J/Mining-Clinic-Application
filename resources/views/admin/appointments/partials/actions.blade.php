<div class="row">
    @if ($row->status !== \App\Models\Appointment::ACCEPTED_STATUS && $row->status !== \App\Models\Appointment::DONE_STATUS)
        <div class="col-sm-2 mr-2 mb-2">
            <a class="btn btn-info btn-sm" href="{{route('admin.reschedule.booking', $row->id)}}"> Reschedule </a>
        </div>
        <div class="col-sm-2 mr-2 mb-2">
            <form action="{{route('admin.appointments.destroy', $row->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fe fe-trash"></i></button>
            </form>
        </div>
    @elseif($row->status === \App\Models\Appointment::DONE_STATUS && $row->sales->count() === 0)
        <div class="col-sm-2 mr-2 mb-2">
            <a class="btn btn-success btn-sm" href="{{route('admin.dispense.medicine', $row->id)}}"> Dispense Patient Medication </a>
        </div>
    @endif

    @if ($row->isXray())
            <div class="col-sm-2 mr-2 mb-2">
                <a href="{{route('admin.patient.xray.show', $row->id)}}" class="btn btn-sm bg-info-light">
                    <i class="far fa-eye"></i> View X-Ray
                </a>
            </div>

        @else
            <div class="col-sm-2 mr-2 mb-2">
                <a href="{{route('admin.patient.xray.upload', $row->id)}}" class="btn btn-sm bg-primary-light">
                    <i class="far fa-asterisk"></i> Upload Xray(s)
                </a>
            </div>
    @endif

</div>

