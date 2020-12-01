<div class="row">
    <div class="col-sm-2">
        <a class="btn btn-info btn-sm" href="{{route('admin.specialists.edit', $row->id)}}" > <i class="fe fe-pencil"></i> </a>
    </div>
    <div class="col-sm-2">
        <form action="{{route('admin.specialists.destroy', $row->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="fe fe-trash"></i></button>
        </form>
    </div>
</div>
