@extends('layouts.doctor')
@section('title')Mining Clinic - Doctor Patients @endsection
@section('breadcrumb')
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Patient Detail</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Patient Detail</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="patients">
        <div class="card">
            <div class="card-header">
                <div class="h4 card-title">Patient {{$patient->full_name}}</div>
            </div>
            <div class="card-body">
                @if($patient->has_medical_aid)

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

                @endif
                <div class="user-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom nav-justified flex-wrap">
                        <li class="nav-item">
                            <a class="nav-link active" href="#pat_appointments" data-toggle="tab">Appointments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#medical" data-toggle="tab"><span class="med-records">Medical Records</span></a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="pat_appointments" class="tab-pane fade show active">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Appointment Date</th>
                                            <th>Appointment Time</th>
                                            <th>Appointment Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($patient->appointments as $key=> $appointment)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$appointment->appointment_date}}</td>
                                                    <td>{{$appointment->appointment_time}}</td>
                                                    <td>
                                                         @if($appointment->status === \App\Models\Appointment::DONE_STATUS)
                                                            <span class="badge badge-pill bg-info-light">Completed</span>
                                                         @elseif($appointment->status === \App\Models\Appointment::ACCEPTED_STATUS)
                                                            <span class="badge badge-pill bg-success-light">Accepted</span>
                                                         @elseif($appointment->status === \App\Models\Appointment::DECLINED_STATUS)
                                                            <span class="badge badge-pill bg-danger-light">Declined</span>
                                                         @elseif($appointment->status === \App\Models\Appointment::PENDING_STATUS)
                                                            <span class="badge badge-pill bg-primary-light">Pending</span>
                                                         @elseif($appointment->status === \App\Models\Appointment::REFERRED_STATUS)
                                                            <span class="badge badge-pill bg-warning-light">Referred</span>
                                                         @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{route('doctor.appointment.details', $appointment->id)}}" class="btn btn-sm bg-info-light">
                                                            <i class="far fa-eye"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Appointment Tab -->
                    <!-- Medical Records Tab -->
                    <div class="tab-pane fade" id="medical">
                        <div class="text-right">
                            <a href="{{route('medical.record.upload', $patient->id)}}" class="add-new-btn" >Add Medical Records</a>
                        </div>
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date </th>
                                            <th>Description</th>
                                            <th>Attachment</th>
                                            <th>Created</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($patient->medicalRecords as $key=>$record)
                                                <tr>
                                                    <td>{{$key + 1 }}</td>
                                                    <td>{{$record->record_date}}</td>
                                                    <td>{{$record->description}}</td>
                                                    <td><a href="{{asset($record->path)}}" target="_blank">{{$record->file_name}}</a></td>
                                                    <td>
                                                        {{$record->user->full_names}}
                                                    </td>
                                                    <td class="text-right">
                                                        <div class="table-action">
                                                            <a href="{{route('medical.record.edit', $record->id)}}" class="btn btn-sm bg-info-light">
                                                                <i class="far fa-pencil"></i> Edit
                                                            </a>
                                                        </div>
                                                    </td>
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
        </div>

    </div>

@endsection

