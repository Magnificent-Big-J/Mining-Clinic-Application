<form action="{{route('admin.appointments.destroy', $row->id)}}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm"><i class="fe fe-trash"></i></button>
</form>
