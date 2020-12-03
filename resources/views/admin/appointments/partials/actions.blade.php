<div class="row">
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
</div>

