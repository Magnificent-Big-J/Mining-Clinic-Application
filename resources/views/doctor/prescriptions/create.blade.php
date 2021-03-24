@extends('layouts.doctor')
@section('title')Mining Clinic - Upload Patient Prescription(s) @endsection
@section('breadcrumb')
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Upload Prescription(s)</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Appointment Upload Prescription(s)</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Upload Prescription(s)</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="biller-info">
                        <h4 class="d-block">{{$appointment->patient->full_name}}</h4>
                        <span class="d-block text-sm text-muted"><i class="fas fa-{{strtolower($appointment->patient->gender)}} mr-1"></i>{{$appointment->patient->gender}}</span>
                        <span><i class="fas fa-phone"></i>{{ $appointment->patient->cell_number }}</span>
                    </div>
                </div>
                <div class="col-sm-6 text-sm-right">
                    <div class="billing-info">
                        <h4 class="d-block">{{$appointment->appointment_date}}</h4>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('doctor.patient-xray.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="appointment" value="{{$appointment->id}}">
                        <input type="hidden" name="document" value="{{$document_type[0]->id}}">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Patient Prescription File:<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="file" accept="image/gif, image/jpeg, image/png, application/pdf" name="xray"  class="form-control" required>
                                @error('xray')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <input type="submit" value="Upload" class="btn btn-primary ">
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('scripts')

@endsection
