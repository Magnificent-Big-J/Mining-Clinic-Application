@component('mail::message')
    # Dear {{$appointment->patient->full_name}},

    Booking request has been  successfully created.<br>
    Appointment detail:

    Doctor Name: {{$appointment->doctor->full_names}}<br>
    Date: {{$appointment->appointment_date}}<br>
    Time: {{$appointment->appointment_time}}<br>

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
