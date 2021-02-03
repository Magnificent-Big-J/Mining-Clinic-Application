
@if ($patient->has_medical !== 'N/A')
    <a href="{{route('admin.medicalAid.edit', $patient->medicalAid[0]->id)}}" class="btn btn-sm btn-primary mr-2">Edit</a>
@endif
{{$patient->has_medical}}
