@component('mail::message')
    # Dear {{$appointment->patient->full_name}},

    The your appointment booking has been rescheduled.<br>
    Patient Name: {{$appointment->patient->full_name}}<br>
    Date: {{$appointment->appointment_date}}<br>
    Time: {{$appointment->appointment_time}}<br>

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
