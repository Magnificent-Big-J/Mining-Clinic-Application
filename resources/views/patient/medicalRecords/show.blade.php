@extends('layouts.doctor')
@section('title')Mining Clinic - Patient Medical Record @endsection

@section('breadcrumb')
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Patient Medical Record</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">View Patient Medical Record</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">View Patient Medical Record</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="biller-info">
                        <h4 class="d-block">{{$medicalRecord->patient->full_name}}</h4>
                        <span class="d-block text-sm text-muted"><i class="fas fa-{{strtolower($medicalRecord->patient->gender)}} mr-1"></i>{{$medicalRecord->patient->gender}}</span>
                        <h5><i class="fas fa-phone text-muted"></i>{{ $medicalRecord->patient->cell_number }}</h5>
                    </div>
                </div>

            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card ">
                        <div class="card-header">
                            <h4 class="card-title">Medical Record Information</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-4">
                                    <strong>Description:</strong>
                                </div>
                                <div class="col-lg-8">
                                    <p> {{$medicalRecord->description}}</p>
                                </div>
                                <div class="col-lg-4">
                                    <strong>Medical Record Date:</strong>
                                </div>
                                <div class="col-lg-8">
                                    <p> {{$medicalRecord->record_date}}</p>
                                </div>

                            </div>
                            @if ($medicalRecord->path)
                                <h4>Medical Record File</h4>
                                <iframe src="{{asset($medicalRecord->path)}}" width="100%" height="380" frameborder="0" allowtransparency="true"></iframe>
                                <a href="{{asset($medicalRecord->path)}}" target="_blank" class="btn btn-primary" download>Download</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
