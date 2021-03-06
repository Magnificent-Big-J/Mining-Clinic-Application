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
                        <li class="breadcrumb-item active">View Patient Information</li>
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
                                <h4 class="card-title">Patient Personal Information</h4>
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
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Age</p>
                                    <p class="col-sm-10">{{$patient->age}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->
                @include('addresses.patient_address')
            </div>

        </div>

        <div class="row">
            @if($patient->has_medical_aid)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Medical Aid Information</h1>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Medical Aid Name</p>
                                <p class="col-sm-10">{{$patient->medicalAid[0]->medical_name}}</p>
                            </div>
                            <div class="row">
                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Medical Aid Number</p>
                                <p class="col-sm-10">{{$patient->medicalAid[0]->medical_aid_number}}</p>
                            </div>
                            <div class="row">
                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Medical Aid Email Address</p>
                                <p class="col-sm-10">{{$patient->medicalAid[0]->medical_email_address}}</p>
                            </div>
                            <div class="row">
                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Medical Aid Status</p>
                                <p class="col-sm-10">{{$patient->medicalAid[0]->medical_status}}</p>
                            </div>
                            <div class="row">
                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Medical Aid Plan</p>
                                <p class="col-sm-10">{{$patient->medicalAid[0]->plan}}</p>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection

