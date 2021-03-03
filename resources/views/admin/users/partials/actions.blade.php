<div class="row">
    <div class="col-sm-4">
        <a  href="{{route('admin.user.profile.edit', $row->id)}}"  class="btn btn-sm btn-info edit-clinic-threshold"><i class="fe fe-pencil"></i></a>
    </div>

    <div class="col-sm-6">
        <div class="col-sm-2 mr-2 mb-2">
            <form action="{{route('admin.user.profile.destroy', $row->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fe fe-trash"></i></button>
            </form>
        </div>

    </div>
</div>
