@component('mail::message')
{{ dump($user->first_name) }}
<p> Hi {{ $user->first_name }} {{ $user->last_name }}, </p>
<p>  Please find your OTP PIN below. This OTP is valid for the next 5 minutes. <strong>   {{$token}}</strong></p>
@component('mail::button', ['url' => config('settings.frontend_url') . '/reset-password?' . $urlQuery])
Reset password
@endcomponent<p> If you’re having trouble with the
    button
    above, copy and paste the URL below into your web
    browser.</p>
<p><p>
@component('mail::panel')
<p>For security, If you did not request a password reset, please
    ignore this email or send a mail to {{ config('mail.from.address') }},
    if you have questions.</p>
@endcomponent {{ config('app.name') }} Team.
@endcomponent
