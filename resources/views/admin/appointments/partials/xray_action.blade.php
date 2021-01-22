@if ($row->isXray())
        <a href="{{route('admin.patient.xray.show', $row->id)}}" class="btn btn-sm bg-info-light">
            <i class="far fa-eye"></i> View X-Ray
        </a>
@else
        <a href="{{route('admin.patient.xray.upload', $row->id)}}" class="btn btn-sm bg-primary-light">
            <i class="far fa-asterisk"></i> Upload Xray(s)
        </a>
@endif
