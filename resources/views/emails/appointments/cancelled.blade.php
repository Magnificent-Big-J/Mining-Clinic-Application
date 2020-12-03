@component('mail::message')
    # Dear {{$appointment->doctor->user->full_names}},

    The below appointment booking has been cancelled and deleted.<br>
    Patient Name: {{$appointment->patient->full_name}}<br>
    Date: {{$appointment->appointment_date}}<br>
    Time: {{$appointment->appointment_time}}<br>

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
