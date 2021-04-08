@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Patients Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">View Patient Medical Record</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">

                <!-- Recent Orders -->
                <div class="card">
                    <div class="card-body">
                        <div class="card ">
                            <div class="card-header">
                                <h4 class="card-title">Patient Personal Information Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">First Name</p>
                                    <p class="col-sm-10">{{$patient->first_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Second Name</p>
                                    <p class="col-sm-10">{{$patient->second_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Last Name</p>
                                    <p class="col-sm-10">{{$patient->last_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Date of Birth</p>
                                    <p class="col-sm-10">{{$patient->date_of_birth}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Identity Number/ Passport Number</p>
                                    <p class="col-sm-10">{{$patient->identity_number}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Ages</p>
                                    <p class="col-sm-10">{{$patient->age}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->

            </div>
        </div>
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
@endsection

