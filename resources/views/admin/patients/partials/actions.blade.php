<a class="btn btn-info btn-sm" href="{{route('admin.patient.show', $patient->id)}}" >Show</a>
<a class="btn btn-secondary btn-sm" href="{{route('admin.patient.edit', $patient->id)}}"> <i class="fe fe-pencil"></i> Edit</a>
<form action="{{route('admin.patient.destroy', $patient->id)}}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm"><i class="fe fe-trash"></i> Delete</button>
</form>
