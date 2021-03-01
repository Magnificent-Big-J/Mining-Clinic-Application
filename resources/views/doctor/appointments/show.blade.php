@extends('layouts.doctor')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
@endsection
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
                                        @if($appointment->documents->count())
                                            <a href="{{route('doctor.patient.show.document', $appointment->id)}}" class="btn btn-sm bg-info">
                                                <i class="far fa-eye"></i> View X-Ray
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">First Name</p>
                                    <p class="col-sm-10">{{$appointment->patient->first_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Second Name</p>
                                    <p class="col-sm-10">{{$appointment->patient->second_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Last Name</p>
                                    <p class="col-sm-10">{{$appointment->patient->last_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Date of Birth</p>
                                    <p class="col-sm-10">{{$appointment->patient->date_of_birth}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Identity Number/ Passport Number</p>
                                    <p class="col-sm-10">{{$appointment->patient->identity_number}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Ages</p>
                                    <p class="col-sm-10">{{$appointment->patient->age}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if($appointment->patient->has_medical_aid)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Medical Aid Information</h1>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Medical Aid Name</p>
                                <p class="col-sm-10">{{$appointment->patient->medicalAid[0]->medical_name}}</p>
                            </div>
                            <div class="row">
                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Medical Aid Number</p>
                                <p class="col-sm-10">{{$appointment->patient->medicalAid[0]->medical_aid_number}}</p>
                            </div>
                            <div class="row">
                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Medical Aid Email Address</p>
                                <p class="col-sm-10">{{$appointment->patient->medicalAid[0]->medical_email_address}}</p>
                            </div>
                            <div class="row">
                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Medical Aid Status</p>
                                <p class="col-sm-10">{{$appointment->patient->medicalAid[0]->medical_status}}</p>
                            </div>
                            <div class="row">
                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Medical Aid Plan</p>
                                <p class="col-sm-10">{{$appointment->patient->medicalAid[0]->plan}}</p>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title">Appointment Assessment Information</h4>

                    </div>
                    <div class="card-body">
                        <h4> <i class="far fa-clock"></i>{{$appointment->appointment_date}} {{$appointment->appointment_time}}</h4>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th>Consultation Fee</th>
                                    <th>Consultation</th>
                                    <th>Consultation Category</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($appointment->appointmentAssessment as $assessment)
                                    <tr>
                                        <td>R {{$assessment->consultationFee->consultation_fee}}</td>
                                        <td>{{$assessment->consultationFee->consultation->name}}</td>
                                        <td>{{$assessment->consultationFee->consultation->consultationCategory->name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title">Appointment Screening Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th>Screening Type</th>
                                    <th>Screening Question</th>
                                    <th>Screening Answer</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($appointment->screening as $screening)
                                    <tr>
                                        <td>{{$screening->screeningQuestionnaire->screeningType->name}}</td>
                                        <td>{{$screening->screeningQuestionnaire->name}}</td>
                                        <td>{{$screening->screening_answer}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Prescriptions</h4>
                    </div>
                    <div class="card-body">
                        @if($appointment->prescriptions->count())
                            <div class="table-responsive">
                               <table class="table mb-0">
                                    <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Days</th>
                                        <th>Quantity</th>
                                        <th>Period</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($appointment->prescriptions as $prescription)
                                        <tr>
                                            <td>{{$prescription->clinicProduct->product->product_name}}</td>
                                            <td>{{$prescription->days}}</td>
                                            <td>{{$prescription->quantity}}</td>
                                            <td>{{$prescription->usage}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            @if ($appointment->isPrescription())
                                @if ($isPdf)
                                    <embed src="{{ asset($document_path)}}" width="100%" height="800" alt="pdf" />
                                @else
                                    <img src="{{ asset($document_path)}}" class="img-fluid img-thumbnail">
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


