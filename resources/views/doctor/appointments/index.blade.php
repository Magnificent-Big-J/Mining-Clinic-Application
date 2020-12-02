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
                            <li class="breadcrumb-item active" aria-current="page">Appointments</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Appointments</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="appointments">

        @foreach($appointments as $appointment)
        <!-- Appointment List -->
        <div class="appointment-list">
            <div class="profile-info-widget">
                <a href="patient-profile.html" class="booking-doc-img">
                    <img src="{{asset('/avatar/generic-avatar.png')}}" alt="User Image">
                </a>
                <div class="profile-det-info">
                    <h3><a href="#">{{ $appointment->patient->first_name }} {{ $appointment->patient->first_name }}</a></h3>
                    <div class="patient-details">
                        <h5><i class="far fa-clock"></i>{{ $appointment->appointment_date }} {{ $appointment->appointment_time }}</h5>
                        <h5><i class="fas fa-{{strtolower($appointment->patient->gender)}}"></i> {{ $appointment->patient->gender }}</h5>
                        @if($appointment->patient->landline)
                        <h5><i class="fas fa-phone"></i>{{ $appointment->patient->landline }}</h5>
                        @elseif($appointment->patient->work_number)
                        <h5><i class="fas fa-phone"></i>{{ $appointment->patient->work_number }}</h5>
                        @endif
                        <h5><i class="fas fa-phone"></i>{{ $appointment->patient->cell_number }}</h5>
                        <h5 class="mb-0">
                            @if((boolean)$appointment->patient->has_medical_aid)
                                <i class="fas fa-credit-card"></i>Medical Aid
                            @else
                                <i class="fas fa-money-bill-alt"></i>Cash Payment
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
            <div class="appointment-action">
                @include('doctor.appointments.partials.actions')
            </div>
        </div>
        <!-- /Appointment List -->
        @endforeach
    </div>
@endsection
