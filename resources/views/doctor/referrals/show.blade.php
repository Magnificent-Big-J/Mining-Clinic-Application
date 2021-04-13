@extends('layouts.doctor')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Patient Appointment</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">View Patient Appointment Details </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card ">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="card-title">Patient Personal Information</h4>
                                    </div>
                                    <div class="col-lg-4">
                                        @if($referral->appointment->isXray())
                                            <a href="{{route('doctor.patient.show.document', $referral->appointment->id)}}" class="btn btn-sm bg-info">
                                                <i class="far fa-eye"></i> View X-Ray
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">First Name</p>
                                    <p class="col-sm-10">{{$referral->appointment->patient->first_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Second Name</p>
                                    <p class="col-sm-10">{{$referral->appointment->patient->second_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Last Name</p>
                                    <p class="col-sm-10">{{$referral->appointment->patient->last_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Date of Birth</p>
                                    <p class="col-sm-10">{{$referral->appointment->patient->date_of_birth}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Identity Number/ Passport Number</p>
                                    <p class="col-sm-10">{{$referral->appointment->patient->identity_number}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Age</p>
                                    <p class="col-sm-10">{{$referral->appointment->patient->age}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title">Referral Information</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-4">
                                <strong>Referral Date:</strong>
                            </div>
                            <div class="col-lg-8">
                                <p> {{$referral->referred_date}}</p>
                            </div>
                            <div class="col-lg-4">
                                <strong>Referral Reason:</strong>
                            </div>
                            <div class="col-lg-8">
                                <p> {{$referral->referral_reason}}</p>
                            </div>
                            <div class="col-lg-4">
                                <strong>Referral By:</strong>
                            </div>
                            <div class="col-lg-8">
                                <p> {{$referral->refer_by_who}}</p>
                            </div>
                            <div class="col-lg-4">
                                <strong>Referral To:</strong>
                            </div>
                            <div class="col-lg-8">
                                <p> {{$referral->referred_to}}</p>
                            </div>
                            @if (!empty($document_path))
                                <div class="col-lg-4">
                                    <strong>Referral File</strong>
                                </div>
                                <div class="col-lg-8">
                                    @if ($isPdf)
                                        <embed src="{{ asset($document_path)}}" width="100%" height="800" alt="pdf" />
                                    @else
                                        <img src="{{ asset($document_path)}}" class="img-fluid img-thumbnail">

                                    @endif
                                </div>
                            @endif

                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

