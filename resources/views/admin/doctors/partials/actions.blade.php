<div class="row">
    <div class="col-sm-2">
        <a class="btn btn-info btn-sm" href="{{route('admin.doctors.show', $row->id)}}" > <i class="fe fe-eye"></i> </a>
    </div>
    <div class="col-sm-2">
        <a class="btn btn-secondary btn-sm" href="{{route('admin.doctors.edit', $row->id)}}"> <i class="fe fe-pencil"></i> </a>
    </div>
    <div class="col-sm-2">
        <a class="btn btn-primary btn-sm" href="{{route('admin.consultation.fee.index', $row->id)}}"> Consultations </a>
    </div>
    <div class="col-sm-2">
        <a class="btn btn-primary btn-sm" href="{{route('admin.doctor.product.index', $row->id)}}"> Product Stock </a>
    </div>
</div>


