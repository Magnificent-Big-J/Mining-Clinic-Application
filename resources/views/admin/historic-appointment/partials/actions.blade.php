<a class="btn btn-info btn-sm mr-2 mb-2" href="{{route('admin.historic-appointment.show', $row->id)}}" > <i class="fe fe-eye"></i> </a>
@if ($row->status === \App\Models\Appointment::DONE_STATUS)
    <a class="btn btn-info btn-sm mr-2 mb-2" href="{{route('admin.medicine.dispensed', $row->id)}}" > <i class="fe fe-eye"></i> View dispensed medication </a>
@endif
