@component('mail::message')
# Dear {{$user->full_names}}

Your profile has been created. Please click the below link to rest your password

@component('mail::button', ['url' => route('password.request')])
Password Reset
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
