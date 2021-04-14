@extends('layouts.doctor')
@section('title')Mining Clinic - Doctor Appointments @endsection
@section('breadcrumb')
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Dashboard</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card dash-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-4">
                            <div class="dash-widget dct-border-rht">
                                <div class="circle-bar circle-bar1">
                                    <div class="circle-graph1" data-percent="75">
                                        <img src="{{asset('doctor/assets/img/icon-03.png')}}" class="img-fluid" alt="patient">
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6>Today's Appointments</h6>
                                    <h3>{{$stats['today_appointments']}}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-4">
                            <div class="dash-widget dct-border-rht">
                                <div class="circle-bar circle-bar2">
                                    <div class="circle-graph2" data-percent="65">
                                        <img src="{{asset('doctor/assets/img/icon-03.png')}}" class="img-fluid" alt="Patient">
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6>Completed Appointments</h6>
                                    <h3>{{$stats['completed_appointments']}}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-4">
                            <div class="dash-widget">
                                <div class="circle-bar circle-bar3">
                                    <div class="circle-graph3" data-percent="50">
                                        <img src="{{asset('doctor/assets/img/icon-03.png')}}" class="img-fluid" alt="Patient">
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6>Upcoming Appointments</h6>
                                    <h3>{{$stats['upcoming_appointments']}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4 class="mb-4">Patient Appoinment</h4>
            <div class="appointment-tab">

                <!-- Appointment Tab -->
                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
                    <li class="nav-item mr-4">
                        <a class="nav-link active" href="#today-appointments" data-toggle="tab">Today</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#upcoming-appointments" data-toggle="tab">Upcoming</a>
                    </li>
                </ul>
                <!-- /Appointment Tab -->

                <div class="tab-content">
                    <!-- Today Appointment Tab -->
                    <div class="tab-pane show active" id="today-appointments">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>Patient Name</th>
                                            <th>Appointment Date</th>
                                            <th>Clinic</th>
                                            <th>Status</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($todayAppointments as $appointment)
                                            <tr>
                                                <td>
                                                    {{$appointment->patient->full_name}}
                                                </td>
                                                <td>{{$appointment->appointment_date}} <span class="d-block text-info">{{$appointment->appointment_time}}</span></td>
                                                <td>{{$appointment->clinic->clinic_name}}</td>
                                                <td>{{$appointment->status_text}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Today Appointment Tab -->

                    <!-- Upcoming Appointment Tab -->
                    <div class="tab-pane" id="upcoming-appointments">
                        <div class="card card-table mb-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>Patient Name</th>
                                            <th>Appointment Date</th>
                                            <th>Clinic</th>
                                            <th>Status</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($upcomingAppointments as $appointment)
                                            <tr>
                                                <td>
                                                    {{$appointment->patient->full_name}}
                                                </td>
                                                <td>{{$appointment->appointment_date}} <span class="d-block text-info">{{$appointment->appointment_time}}</span></td>
                                                <td>{{$appointment->clinic->clinic_name}}</td>
                                                <td>{{$appointment->status_text}}</td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Upcoming Appointment Tab -->

                </div>
            </div>
        </div>
        </div>

@endsection
