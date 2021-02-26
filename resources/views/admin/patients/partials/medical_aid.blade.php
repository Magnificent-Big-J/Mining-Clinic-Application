
@if ($patient->has_medical !== 'N/A')
    <a data-toggle="modal" href="#edit-medical-aid-modal" id="{{$patient->medicalAid[0]->id}}" class="btn btn-sm btn-info edit-medical-aid"><i class="fa fa-pencil"></i></a>
    @else
    <a data-toggle="modal" href="#has-medical-modal" id="{{$patient->id}}" class="btn btn-sm btn-info add-medical-aid"><i class="fa fa-plus"></i></a>
@endif
{{$patient->has_medical}}
