@component('mail::message')
<p> Hi {{ $user->first_name }} {{ $user->last_name }}, </p>
<p> You recently requested to reset the password for your account. Use the
    button below to reset it. <strong>This password reset is only valid for the next 1 hour.</strong></p>
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
