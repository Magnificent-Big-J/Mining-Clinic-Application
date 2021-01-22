<form action="{{route('admin.patients.destroy', $patient->id)}}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm"><i class="fe fe-trash"></i></button>
</form>
