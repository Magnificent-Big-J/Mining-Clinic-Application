<div class="row">
    <div class="col-sm-2">
        <a class="btn btn-info btn-sm" href="{{route('admin.patients.show', $patient->id)}}" > <i class="fe fe-eye"></i> </a>
    </div>
    <div class="col-sm-2">
        <a class="btn btn-secondary btn-sm" href="{{route('admin.patients.edit', $patient->id)}}"> <i class="fe fe-pencil"></i> </a>
    </div>
    <div class="col-sm-2">
        <form action="{{route('admin.patients.destroy', $patient->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="fe fe-trash"></i></button>
        </form>

    </div>
    <div class="col-sm-2">
        <form action="{{route('admin.booking')}}" method="post">
            @csrf
            <input type="hidden" name="patient" value="{{$patient->id}}">
            <button type="submit" class="btn btn-secondary btn-sm">Book Appointment</button>
        </form>

    </div>
</div>


