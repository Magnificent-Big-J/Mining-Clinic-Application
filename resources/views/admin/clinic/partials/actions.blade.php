<div class="row">
    <div class="col-sm-6">
        <a data-toggle="modal" href="#edit-mining-clinic-modal" id="{{$clinic->id}}" class="btn btn-sm btn-info edit-mining-clinic-record"><i class="fa fa-pencil"></i></a>
    </div>
    <div class="col-sm-6">
        <form action="{{route('admin.clinic.destroy', $clinic->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="fe fe-trash"></i></button>
        </form>
    </div>
</div>

