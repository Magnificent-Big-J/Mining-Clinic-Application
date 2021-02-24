
<div class="row">
    <div class="col-sm-2 mr-2 mb-2">
        <a href="{{route('admin.consultation.edit',$row->id)}}"  class="btn btn-sm btn-info edit-consultation"><i class="fe fe-pencil"></i></a>

    </div>
    <div class="col-sm-2 mr-2 mb-2">
        <form action="{{route('admin.consultation.destroy', $row->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="fe fe-trash"></i></button>
        </form>
    </div>

</div>
