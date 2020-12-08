@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Patient Appointment</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">View Patient Appointment History </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card ">
                            <div class="card-header">
                                <h4 class="card-title">Patient Personal Information</h4>
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card ">
                            <div class="card-header">
                                <h4 class="card-title">Doctor Information Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Doctor</p>
                                    <p class="col-sm-10">{{$appointment->doctor->user->full_names}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Doctor Entity</p>
                                    <p class="col-sm-10">{{$appointment->doctor->entity_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Practice Number</p>
                                    <p class="col-sm-10">{{$appointment->doctor->practice_number}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Registration Number</p>
                                    <p class="col-sm-10">{{$appointment->doctor->reg_number}}</p>
                                </div>

                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Telephone Number</p>
                                    <p class="col-sm-10">{{$appointment->doctor->tele_number}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Address</p>
                                    <p class="col-sm-10">{{$appointment->doctor->address}}</p>
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
                        <h4 class="card-title">Appointment Assessment Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                        <th>Consultation Fee</th>
                                        <th>Consultation</th>
                                        <th>Consultation Category</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointment->appointmentAssessment as $assessment)
                                        <tr>
                                            <td>{{$assessment->appointment->appointment_date}}</td>
                                            <td>{{$assessment->appointment->appointment_time}}</td>
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
    </div>
@endsection

