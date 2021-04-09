@component('mail::message')
# Dear {{$appointment->patient->full_name}}

Your appointment with {{$appointment->doctor->user->full_names}}<br>
For {{$appointment->appointment_date}} at {{$appointment->appointment_time}} has been declined.<br>

Please visit the mining clinic to reschedule the appointment.<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
