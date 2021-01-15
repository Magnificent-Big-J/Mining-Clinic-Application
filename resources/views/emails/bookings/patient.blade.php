@component('mail::message')
    # Dear {{$appointment->doctor->user->full_names}},

    Appointment have been rescheduled, details below.<br>
    Patient Name: {{$appointment->patient->full_name}}<br>
    Date: {{$appointment->appointment_date}}<br>
    Time: {{$appointment->appointment_time}}<br>

    Please login into the system to approve the appointment<br>

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
