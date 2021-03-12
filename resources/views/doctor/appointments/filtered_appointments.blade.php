@forelse($appointments as $appointment)
    <!-- Appointment List -->
    <div class="appointment-list">
        <div class="profile-info-widget">
            <a href="patient-profile.html" class="booking-doc-img">
                <img src="{{asset('/avatar/generic-avatar.png')}}" alt="User Image">
            </a>
            <div class="profile-det-info">
                <h3><a href="#">{{ $appointment->patient->full_name }} </a></h3>
                <div class="patient-details">
                    <h5><i class="far fa-clock"></i>{{ $appointment->appointment_date }} {{ $appointment->appointment_time }}</h5>
                    <h5><i class="fas fa-{{strtolower($appointment->patient->gender)}}"></i> {{ $appointment->patient->gender }}</h5>
                    @if($appointment->patient->landline)
                        <h5><i class="fas fa-phone"></i>{{ $appointment->patient->landline }}</h5>
                    @elseif($appointment->patient->work_number)
                        <h5><i class="fas fa-phone"></i>{{ $appointment->patient->work_number }}</h5>
                    @endif
                    <h5><i class="fas fa-phone"></i>{{ $appointment->patient->cell_number }}</h5>

                </div>
            </div>
        </div>
        <div class="appointment-action">
            @include('doctor.appointments.partials.actions')
        </div>
    </div>
    <!-- /Appointment List -->
@empty
    <h1>No appointments record(s)</h1>
@endforelse
