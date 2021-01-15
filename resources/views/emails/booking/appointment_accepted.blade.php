@component('mail::message')
    # Dear {{$appointment->patient->full_name}}

    Your appointment with {{$appointment->doctor->user->full_names}}<br>
    For {{$appointment->appointment_date}} at {{$appointment->appointment_time}} has been successfully accepted.<br>

    You may visit the doctor.<br>

    Thanks,<br>
    {{ config('app.name') }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
